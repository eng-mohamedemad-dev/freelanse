<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Session::get('cart', collect());
        $cartItems = collect();
        
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems->push([
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $product->final_price * $item['quantity']
                ]);
            }
        }
        
        $subtotal = $cartItems->sum('total');
        $tax = $subtotal * 0.1; // 10% tax
        $shipping = $subtotal > 100 ? 0 : 10; // Free shipping over $100
        $total = $subtotal + $tax + $shipping;
        
        return view('website.cart.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ]);
        }

        $cart = Session::get('cart', collect());
        $existingItem = $cart->firstWhere('product_id', $request->product_id);
        
        if ($existingItem) {
            $existingItem['quantity'] += $request->quantity;
        } else {
            $cart->push([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج إلى السلة',
            'cart_count' => $cart->count()
        ]);
    }

    /**
     * Update cart item
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', collect());
        $item = $cart->firstWhere('product_id', $request->product_id);
        
        if ($item) {
            $item['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث السلة'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart', collect());
        $cart = $cart->reject(function ($item) use ($request) {
            return $item['product_id'] == $request->product_id;
        });
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'تم إزالة المنتج من السلة',
            'cart_count' => $cart->count()
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'تم مسح السلة'
        ]);
    }
}
