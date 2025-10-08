<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->paginate(10);
        
        return view('website.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($id);
        
        return view('website.orders.show', compact('order'));
    }

    public function invoice($id)
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($id);
        
        return view('website.orders.invoice', compact('order'));
    }
}