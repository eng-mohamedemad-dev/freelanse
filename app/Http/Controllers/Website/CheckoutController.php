<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Contracts\OrderServiceInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = Session::get('cart', collect());
        
        if ($cart->isEmpty()) {
            return redirect()->route('website.cart.index')
                ->with('error', 'السلة فارغة');
        }
        
        $cartItems = collect();
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->final_price * $item['quantity'];
                $subtotal += $itemTotal;
                
                $cartItems->push([
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ]);
            }
        }
        
        $tax = $subtotal * 0.1; // 10% tax
        $shipping = $subtotal > 100 ? 0 : 10; // Free shipping over $100
        $total = $subtotal + $tax + $shipping;
        
        return view('website.checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'billing_address' => 'required|string|max:500',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery,credit_card,paypal',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = Session::get('cart', collect());
        
        if ($cart->isEmpty()) {
            return redirect()->route('website.cart.index')
                ->with('error', 'السلة فارغة');
        }

        // Prepare order data
        $orderData = [
            'order_number' => 'ORD-' . time(),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'billing_address' => [
                'address' => $request->billing_address,
            ],
            'shipping_address' => [
                'address' => $request->shipping_address,
            ],
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'whatsapp_number' => $request->customer_phone,
        ];

        // Calculate totals
        $subtotal = 0;
        $items = [];
        
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->final_price * $item['quantity'];
                $subtotal += $itemTotal;
                
                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->final_price,
                ];
            }
        }
        
        $tax = $subtotal * 0.1;
        $shipping = $subtotal > 100 ? 0 : 10;
        $total = $subtotal + $tax + $shipping;
        
        $orderData['subtotal'] = $subtotal;
        $orderData['tax_amount'] = $tax;
        $orderData['shipping_amount'] = $shipping;
        $orderData['total_amount'] = $total;

        try {
            $order = $this->orderService->createOrder($orderData, $items);
            
            // Clear cart
            Session::forget('cart');
            
            return redirect()->route('website.checkout.success', $order)
                ->with('success', 'تم إنشاء الطلب بنجاح');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إنشاء الطلب');
        }
    }

    /**
     * Show success page
     */
    public function success($order)
    {
        $order = \App\Models\Order::where('order_number', $order)
            ->orWhere('id', $order)
            ->firstOrFail();
            
        return view('website.checkout.success', compact('order'));
    }

    /**
     * Show cancel page
     */
    public function cancel()
    {
        return view('website.checkout.cancel');
    }
}
