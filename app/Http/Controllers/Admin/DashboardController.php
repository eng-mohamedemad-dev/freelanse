<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderServiceInterface;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $statistics = $this->orderService->getOrderStatistics();
        $recentOrders = $this->orderService->getRecentOrders(5);
        $salesData = $this->orderService->getSalesChartData(30);
        
        // Get top products
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'statistics',
            'recentOrders', 
            'salesData',
            'topProducts'
        ));
    }

    public function salesReport(Request $request)
    {
        $period = $request->get('period', '30');
        $salesData = $this->orderService->getSalesChartData($period);
        
        return response()->json($salesData);
    }

    public function productsReport()
    {
        $products = Product::withCount('orderItems')
            ->with(['category', 'brand'])
            ->orderBy('order_items_count', 'desc')
            ->get();

        return view('admin.reports.products', compact('products'));
    }

    public function customersReport()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->get();

        return view('admin.reports.customers', compact('customers'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('uploads/images', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/files', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path
        ]);
    }
}
