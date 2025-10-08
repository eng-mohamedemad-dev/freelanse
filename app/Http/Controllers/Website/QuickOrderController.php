<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Contracts\OrderServiceInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class QuickOrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
            ]);
        }

        // Create order data
        $orderData = [
            'order_number' => 'QO-' . time(),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => auth()->user()->email ?? 'guest@example.com',
            'customer_phone' => $request->customer_phone,
            'billing_address' => [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'address' => $request->customer_address,
            ],
            'shipping_address' => [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'address' => $request->customer_address,
            ],
            'subtotal' => $product->final_price * $request->quantity,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total_amount' => $product->final_price * $request->quantity,
            'status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'notes' => 'طلب سريع',
            'whatsapp_number' => $request->customer_phone,
        ];

        // Create order items
        $items = [
            [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->final_price,
            ]
        ];

        try {
            $order = $this->orderService->createOrder($orderData, $items);

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الطلب'
            ]);
        }
    }
}
