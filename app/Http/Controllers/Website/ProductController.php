<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $products = $query->latest()->paginate(12)->withQueryString();
        return view('website.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);
        return view('website.products.show', compact('product'));
    }

    public function quickView(Product $product)
    {
        abort_unless($product->status === 'active', 404);

        $images = [];
        if (is_array($product->images) && count($product->images) > 0) {
            foreach ($product->images as $pathOrName) {
                // إذا كانت القيمة تحتوي على مسار مسبقاً مثل "uploads/products/..." استخدمها كما هي
                $normalized = str_starts_with($pathOrName, 'uploads/') || str_starts_with($pathOrName, 'assets/')
                    ? $pathOrName
                    : ('uploads/products/' . $pathOrName);
                $images[] = asset($normalized);
            }
        } else {
            $images[] = asset('assets/website/images/product-detail-01.jpg');
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->display_name,
            'description' => $product->display_description,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'final_price' => $product->final_price,
            'stock' => $product->stock,
            'images' => $images,
            'category' => optional($product->category)->display_name,
            'url' => route('website.products.show', $product),
        ]);
    }
}


