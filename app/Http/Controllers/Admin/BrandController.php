<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(20);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('uploads/brands', $filename, 'public');
            $data['logo'] = $path;
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')
            ->with('success', __('admin.brand_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brand->load('products');
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($brand->logo && \Storage::disk('public')->exists($brand->logo)) {
                \Storage::disk('public')->delete($brand->logo);
            }
            
            $logo = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('uploads/brands', $filename, 'public');
            $data['logo'] = $path;
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', __('admin.brand_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', __('admin.brand_has_products'));
        }

        // Delete logo
        if ($brand->logo && \Storage::disk('public')->exists($brand->logo)) {
            \Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', __('admin.brand_deleted_successfully'));
    }

    /**
     * Toggle brand status
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->update([
            'status' => $brand->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'status' => $brand->status
        ]);
    }
}
