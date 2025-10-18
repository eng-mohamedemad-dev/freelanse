<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', '%' . $search . '%')
                  ->orWhere('name_en', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('description_ar', 'like', '%' . $search . '%')
                  ->orWhere('description_en', 'like', '%' . $search . '%');
            });
        }

        // تصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // تصفية حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // ترتيب
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $coupons = $query->paginate(10);

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->has('ajax')) {
            // أعد HTML الجدول الكامل داخل الـ wrapper كما هو في الصفحة
            $html = view('admin.coupons._table', compact('coupons'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'fixed_value' => 'required_if:type,fixed|nullable|numeric|min:0',
            'percentage_value' => 'required_if:type,percentage|nullable|numeric|min:1|max:100',
            // 'minimum_amount' removed from UI; keep nullable if sent
            'minimum_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // status now defaulted to active
        ]);

        $data = $request->except(['fixed_value','percentage_value']);
        $data['name_ar'] = $data['name_ar'] ?? ($request->name_ar ?? null);
        $data['name_en'] = $data['name_en'] ?? ($request->name_en ?? null);
        $data['description_ar'] = $data['description_ar'] ?? ($request->description_ar ?? null);
        $data['description_en'] = $data['description_en'] ?? ($request->description_en ?? null);

        // Set the value based on type
        if ($request->type === 'fixed') {
            $data['value'] = $request->fixed_value;
        } else if ($request->type === 'percentage') {
            $data['value'] = $request->percentage_value;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/coupons');
            
            // إنشاء المجلد إذا لم يكن موجوداً
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // نقل الملف
            $image->move($uploadPath, $filename);
            $data['image'] = 'uploads/coupons/' . $filename;
        }

        // تحويل التواريخ
        if ($request->filled('expires_at')) {
            $data['expires_at'] = Carbon::parse($request->expires_at)->format('Y-m-d');
        }

        // Default status to active
        $data['status'] = 'active';

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')
            ->with('success', __('admin.coupon_created_successfully'));
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'fixed_value' => 'required_if:type,fixed|nullable|numeric|min:0',
            'percentage_value' => 'required_if:type,percentage|nullable|numeric|min:1|max:100',
            // 'minimum_amount' optional
            'minimum_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // status no longer editable from UI; keep current status
        ]);

        $data = $request->except(['fixed_value','percentage_value','status']);
        $data['name_ar'] = $data['name_ar'] ?? ($request->name_ar ?? $coupon->name_ar);
        $data['name_en'] = $data['name_en'] ?? ($request->name_en ?? $coupon->name_en);
        $data['description_ar'] = $data['description_ar'] ?? ($request->description_ar ?? $coupon->description_ar);
        $data['description_en'] = $data['description_en'] ?? ($request->description_en ?? $coupon->description_en);

        // Set the value based on type
        if ($request->type === 'fixed') {
            $data['value'] = $request->fixed_value;
        } else if ($request->type === 'percentage') {
            $data['value'] = $request->percentage_value;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($coupon->image && file_exists(public_path($coupon->image))) {
                unlink(public_path($coupon->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/coupons');
            
            // إنشاء المجلد إذا لم يكن موجوداً
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // نقل الملف
            $image->move($uploadPath, $filename);
            $data['image'] = 'uploads/coupons/' . $filename;
        }

        // تحويل التواريخ
        if ($request->filled('expires_at')) {
            $data['expires_at'] = Carbon::parse($request->expires_at)->format('Y-m-d');
        }

        // Preserve existing status as active (or current value)
        if (!isset($data['status'])) {
            $data['status'] = $coupon->status ?? 'active';
        }
        $coupon->update($data);

        return redirect()->route('admin.coupons.index')
            ->with('success', __('admin.coupon_updated_successfully'));
    }

    public function destroy(Coupon $coupon)
    {
        // حذف الصورة
        if ($coupon->image && file_exists(public_path($coupon->image))) {
            unlink(public_path($coupon->image));
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', __('admin.coupon_deleted_successfully'));
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update([
            'status' => $coupon->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'status' => $coupon->status
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'bulk_action' => 'required|in:activate,deactivate,delete',
            'selected_items' => 'required|array|min:1',
        ]);

        $action = $request->bulk_action;
        $selectedItems = $request->selected_items;

        switch ($action) {
            case 'activate':
                Coupon::whereIn('id', $selectedItems)->update(['status' => 'active']);
                $message = __('admin.coupons_activated_successfully');
                break;
            case 'deactivate':
                Coupon::whereIn('id', $selectedItems)->update(['status' => 'inactive']);
                $message = __('admin.coupons_deactivated_successfully');
                break;
            case 'delete':
                $coupons = Coupon::whereIn('id', $selectedItems)->get();
                foreach ($coupons as $coupon) {
                    if ($coupon->image && file_exists(public_path($coupon->image))) {
                        unlink(public_path($coupon->image));
                    }
                }
                Coupon::whereIn('id', $selectedItems)->delete();
                $message = __('admin.coupons_deleted_successfully');
                break;
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', $message);
    }

    public function deleteImage(Coupon $coupon)
    {
        if ($coupon->image && file_exists(public_path($coupon->image))) {
            unlink(public_path($coupon->image));
            $coupon->update(['image' => null]);
            
            return response()->json([
                'success' => true,
                'message' => __('admin.image_deleted_successfully')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('admin.image_not_found')
        ], 404);
    }
}