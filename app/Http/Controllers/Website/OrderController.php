<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Track order
     */
    public function track(Order $order)
    {
        // Check if user owns this order
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load(['items.product', 'user']);
        
        return view('website.orders.track', compact('order'));
    }

    /**
     * Download invoice
     */
    public function invoice(Order $order)
    {
        // Check if user owns this order
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load(['items.product', 'user']);
        
        return view('website.orders.invoice', compact('order'));
    }
}
