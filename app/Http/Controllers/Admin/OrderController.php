<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderServiceInterface;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $this->orderService->updateOrderStatus($order, $request->status);

        return redirect()->route('admin.orders.index')
            ->with('success', __('admin.order_status_updated_successfully'));
    }

    public function invoice(Order $order)
    {
        $order->load(['user', 'items.product']);
        
        return view('admin.orders.invoice', compact('order'));
    }

    public function markAsCompleted(Order $order)
    {
        $this->orderService->updateOrderStatus($order, 'delivered');

        return response()->json([
            'success' => true,
            'message' => __('admin.order_marked_as_completed')
        ]);
    }

    public function markAsCancelled(Order $order)
    {
        $this->orderService->updateOrderStatus($order, 'cancelled');

        return response()->json([
            'success' => true,
            'message' => __('admin.order_marked_as_cancelled')
        ]);
    }
}
