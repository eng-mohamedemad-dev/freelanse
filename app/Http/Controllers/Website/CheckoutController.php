<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', collect());
        
        if ($cart->isEmpty()) {
            return redirect()->route('website.cart.index')
                ->with('error', __('website.cart_is_empty'));
        }
        
        return view('website.checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery,credit_card',
        ]);

        // Here you would process the order
        // For now, we'll just clear the cart and redirect
        
        session()->forget('cart');
        
        return redirect()->route('website.home')
            ->with('success', __('website.order_placed_successfully'));
    }
}