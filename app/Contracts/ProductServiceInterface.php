<?php

namespace App\Contracts;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function getAllProducts(Request $request);
    public function createProduct(array $data);
    public function updateProduct(Product $product, array $data);
    public function deleteProduct(Product $product);
    public function getFeaturedProducts($limit = 8);
    public function getProductsByCategory(Category $category, $limit = 20);
    public function searchProducts($searchTerm, $limit = 20);
}
