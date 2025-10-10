<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserPoint;
use App\Models\Setting;
use App\Contracts\OrderServiceInterface;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    public function createOrder(array $orderData, array $items)
    {
        return DB::transaction(function () use ($orderData, $items) {
            // Create order
            $order = Order::create($orderData);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Award points if enabled
            if (Setting::getBoolean('points_system_enabled', false)) {
                $this->awardPointsForOrder($order);
            }

            return $order;
        });
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);
        
        // If order is cancelled, restore stock
        if ($status === 'cancelled') {
            $this->restoreStock($order);
        }
    }

    public function getOrderStatistics()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_revenue' => Order::where('status', 'pending')->sum('total_amount'),
            'delivered_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'cancelled_revenue' => Order::where('status', 'cancelled')->sum('total_amount'),
            'total_products' => \App\Models\Product::count(),
            'total_users' => \App\Models\User::count(),
        ];
    }

    public function getSalesChartData($period = '30')
    {
        // Generate monthly data for the chart
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $revenue = [];
        $orders = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $year = now()->year;
            
            $monthRevenue = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
            
            $monthOrders = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', '!=', 'cancelled')
                ->count();
            
            $revenue[] = round($monthRevenue / 1000, 2); // Convert to thousands
            $orders[] = round($monthOrders / 1000, 2); // Convert to thousands
        }

        return [
            'revenue' => $revenue,
            'orders' => $orders,
            'months' => $months,
            'pending' => $this->getPendingData(),
            'delivered' => $this->getDeliveredData()
        ];
    }

    private function getPendingData()
    {
        $data = [];
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $year = now()->year;
            
            $monthPending = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'pending')
                ->sum('total_amount');
            
            $data[] = round($monthPending / 1000, 2);
        }
        return $data;
    }

    private function getDeliveredData()
    {
        $data = [];
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $year = now()->year;
            
            $monthDelivered = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'delivered')
                ->sum('total_amount');
            
            $data[] = round($monthDelivered / 1000, 2);
        }
        return $data;
    }

    private function awardPointsForOrder(Order $order)
    {
        $pointsPerDollar = Setting::getInteger('points_per_dollar', 1);
        $points = (int) ($order->total_amount * $pointsPerDollar);

        if ($points > 0) {
            UserPoint::create([
                'user_id' => $order->user_id,
                'points' => $points,
                'type' => 'earned',
                'description' => 'نقاط من الطلب #' . $order->order_number,
                'order_id' => $order->id,
            ]);
        }
    }

    private function restoreStock(Order $order)
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
    }

    public function getRecentOrders($limit = 10)
    {
        return Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
