<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProducts($request);
        $categories = Category::active()->get();

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'html' => view('admin.products.partials.table', compact('products'))->render(),
                'count' => $products->count()
            ]);
        }

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {

        // إضافة الحالة تلقائياً كنشط
        $data = $request->validated();
        $data['status'] = 'active';
        
        $product = $this->productService->createProduct($data);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.product_created_successfully'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'reviews.user']);
        
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $data = $request->validated();
        
        // Handle removed images
        if ($request->has('removed_images')) {
            $currentImages = $product->images ?? [];
            $removedImages = $request->removed_images;
            $data['images'] = array_diff($currentImages, $removedImages);
        }
        
        $this->productService->updateProduct($product, $data);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.product_updated_successfully'));
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.product_deleted_successfully'));
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'status' => $product->status
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'bulk_action' => 'required|in:activate,deactivate,delete',
            'selected_items' => 'required|array|min:1',
        ]);

        $action = $request->bulk_action;
        $selectedItems = $request->selected_items;

        switch ($action) {
            case 'activate':
                Product::whereIn('id', $selectedItems)->update(['status' => 'active']);
                $message = __('admin.products_activated_successfully');
                break;
            case 'deactivate':
                Product::whereIn('id', $selectedItems)->update(['status' => 'inactive']);
                $message = __('admin.products_deactivated_successfully');
                break;
            case 'delete':
                Product::whereIn('id', $selectedItems)->delete();
                $message = __('admin.products_deleted_successfully');
                break;
        }

        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }
}
