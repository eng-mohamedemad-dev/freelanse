<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Coupon;

class CartService
{
    private string $key = 'website_cart';

    public function get(): array
    {
        return session($this->key, ['items' => []]);
    }

    public function isEmpty(): bool
    {
        $cart = $this->get();
        return empty($cart['items']);
    }

    public function add(array $data): void
    {
        $cart = $this->get();
        $product = Product::findOrFail($data['product_id']);
        $price = $product->sale_price ?? $product->price;

        $existingKey = collect($cart['items'])->search(fn ($i) => $i['product_id'] == $product->id);

        if ($existingKey !== false) {
            $cart['items'][$existingKey]['qty'] += (int) $data['qty'];
        } else {
            $cart['items'][] = [
                'product_id' => $product->id,
                'name' => $product->display_name,
                'price' => (float) $price,
                'qty' => (int) $data['qty'],
                'image' => optional(collect($product->images))->first(),
            ];
        }

        session([$this->key => $cart]);
    }

    public function update(int $productId, int $qty): void
    {
        $cart = $this->get();
        foreach ($cart['items'] as &$item) {
            if ($item['product_id'] == $productId) {
                $item['qty'] = $qty;
                break;
            }
        }
        session([$this->key => $cart]);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        $cart['items'] = array_values(array_filter($cart['items'], fn ($i) => $i['product_id'] != $productId));
        session([$this->key => $cart]);
    }

    public function clear(): void
    {
        session()->forget($this->key);
    }

    public function totals(?string $couponCode = null): array
    {
        $cart = $this->get();
        $subtotal = collect($cart['items'])->sum(fn ($i) => $i['price'] * $i['qty']);

        $discount = 0;
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->where('status', 'active')->first();
            if ($coupon && (!$coupon->expires_at || $coupon->expires_at >= now())) {
                $discount = $coupon->type === 'fixed' ? $coupon->value : ($subtotal * $coupon->value / 100);
            }
        }

        $total = max(0, $subtotal - $discount);
        return compact('subtotal', 'discount', 'total');
    }
}


