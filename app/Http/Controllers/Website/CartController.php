<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', collect());
        return view('website.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        
        $cart = session('cart', collect());
        
        if ($cart->has($productId)) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => __('website.product_added_to_cart'),
            'cart_count' => $cart->count()
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session('cart', collect());
        
        if ($quantity <= 0) {
            $cart->forget($productId);
        } else {
            $cart[$productId] = $quantity;
        }
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => __('website.cart_updated'),
            'cart_count' => $cart->count()
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        
        $cart = session('cart', collect());
        $cart->forget($productId);
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => __('website.product_removed_from_cart'),
            'cart_count' => $cart->count()
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => __('website.cart_cleared')
        ]);
    }
}