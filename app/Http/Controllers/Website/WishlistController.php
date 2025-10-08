<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->paginate(20);
        
        return view('website.wishlist.index', compact('wishlist'));
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج إلى قائمة الأمنيات',
            'in_wishlist' => true
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'تم إزالة المنتج من قائمة الأمنيات',
            'in_wishlist' => false
        ]);
    }

    /**
     * Toggle wishlist item
     */
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            $inWishlist = false;
            $message = 'تم إزالة المنتج من قائمة الأمنيات';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ]);
            $inWishlist = true;
            $message = 'تم إضافة المنتج إلى قائمة الأمنيات';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist
        ]);
    }
}
