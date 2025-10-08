<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display account dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $reviewsCount = Review::where('user_id', $user->id)->count();
        
        return view('website.account.dashboard', compact(
            'user', 
            'recentOrders', 
            'wishlistCount', 
            'reviewsCount'
        ));
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('website.account.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('website.account.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Display user addresses
     */
    public function addresses()
    {
        $user = Auth::user();
        return view('website.account.addresses', compact('user'));
    }

    /**
     * Create new address
     */
    public function createAddress()
    {
        return view('website.account.addresses.create');
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Store address logic here
        // This would typically involve creating an Address model
        
        return redirect()->route('website.account.addresses')
            ->with('success', 'تم إضافة العنوان بنجاح');
    }

    /**
     * Edit address
     */
    public function editAddress($address)
    {
        return view('website.account.addresses.edit', compact('address'));
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request, $address)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Update address logic here
        
        return redirect()->route('website.account.addresses')
            ->with('success', 'تم تحديث العنوان بنجاح');
    }

    /**
     * Delete address
     */
    public function destroyAddress($address)
    {
        // Delete address logic here
        
        return redirect()->route('website.account.addresses')
            ->with('success', 'تم حذف العنوان بنجاح');
    }

    /**
     * Display user orders
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('website.account.orders', compact('orders'));
    }

    /**
     * Display order details
     */
    public function orderDetails(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load(['items.product']);
        return view('website.account.order-details', compact('order'));
    }

    /**
     * Display user wishlist
     */
    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->paginate(20);
        
        return view('website.account.wishlist', compact('wishlist'));
    }

    /**
     * Display user reviews
     */
    public function reviews()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('product')
            ->paginate(20);
        
        return view('website.account.reviews', compact('reviews'));
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()
                ->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('website.account.profile')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
