<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session('wishlist', collect());
        $products = Product::whereIn('id', $wishlist->keys())->get();
        
        return view('website.wishlist.index', compact('products'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        
        $wishlist = session('wishlist', collect());
        $wishlist->put($productId, true);
        
        session(['wishlist' => $wishlist]);
        
        return response()->json([
            'success' => true,
            'message' => __('website.product_added_to_wishlist')
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        
        $wishlist = session('wishlist', collect());
        $wishlist->forget($productId);
        
        session(['wishlist' => $wishlist]);
        
        return response()->json([
            'success' => true,
            'message' => __('website.product_removed_from_wishlist')
        ]);
    }
}