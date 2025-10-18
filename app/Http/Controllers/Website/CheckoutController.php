<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart, private OrderService $orders)
    {
    }

    public function index()
    {
        abort_if($this->cart->isEmpty(), 404);
        return view('website.checkout.index', [
            'cart' => $this->cart->get(),
            'totals' => $this->cart->totals(),
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $payload = $request->validated();
        $cart = $this->cart->get();
        $totals = $this->cart->totals($payload['coupon_code'] ?? null);

        $orderData = [
            'order_number' => Str::upper(Str::random(10)),
            'user_id' => auth()->id(),
            'customer_name' => $payload['name'],
            'customer_email' => $payload['email'] ?? null,
            'customer_phone' => $payload['phone'],
            'whatsapp_number' => $payload['whatsapp'],
            'billing_address' => json_encode(['address' => $payload['address']]),
            'shipping_address' => json_encode(['address' => $payload['address']]),
            'subtotal' => $totals['subtotal'],
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => $totals['discount'],
            'total_amount' => $totals['total'],
            'status' => 'pending',
            'payment_method' => null,
            'payment_status' => 'pending',
            'notes' => $payload['notes'] ?? null,
        ];

        $items = collect($cart['items'])->map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ];
        })->all();

        $order = $this->orders->createOrder($orderData, $items);

        $this->cart->clear();

        return view('website.checkout.success', compact('order'));
    }
}


