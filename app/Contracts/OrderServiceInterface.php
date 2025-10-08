<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderServiceInterface
{
    public function createOrder(array $orderData, array $items);
    public function updateOrderStatus(Order $order, string $status);
    public function getOrderStatistics();
    public function getSalesChartData($period = '30');
    public function getRecentOrders($limit = 10);
}
