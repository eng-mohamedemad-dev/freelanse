<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart)
    {
    }

    public function index()
    {
        return view('website.cart.index', [
            'cart' => $this->cart->get(),
            'totals' => $this->cart->totals(),
        ]);
    }

    public function store(StoreCartItemRequest $request)
    {
        $this->cart->add($request->validated());
        return redirect()->route('website.cart.index');
    }

    public function update(Request $request, int $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $this->cart->update($product, $qty);
        return redirect()->route('website.cart.index');
    }

    public function destroy(int $product)
    {
        $this->cart->remove($product);
        return redirect()->route('website.cart.index');
    }

    public function clear()
    {
        $this->cart->clear();
        return redirect()->route('website.cart.index');
    }
}


