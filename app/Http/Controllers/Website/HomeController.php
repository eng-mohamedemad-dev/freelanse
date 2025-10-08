<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Contracts\ProductServiceInterface;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $featuredProducts = $this->productService->getFeaturedProducts(8);
        $categories = Category::active()->root()->with('children')->get();
        
        return view('website.home', compact('featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('website.about');
    }

    public function contact()
    {
        return view('website.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you would typically send an email or store the contact form
        // For now, we'll just return a success message

        return redirect()->route('website.contact')
            ->with('success', __('website.contact_message_sent_successfully'));
    }
}
