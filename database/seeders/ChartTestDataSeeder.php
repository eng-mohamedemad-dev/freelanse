<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class ChartTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create more orders for current year (2024) to test chart
        $this->createCurrentYearOrders();
        
        // Create orders for previous year (2023) for comparison
        $this->createPreviousYearOrders();
    }
    
    private function createCurrentYearOrders()
    {
        $users = User::all();
        $products = Product::all();
        
        // Create orders for each month of 2024 with varying amounts
        $monthlyData = [
            ['month' => 1, 'orders' => 15, 'avg_amount' => 500], // يناير
            ['month' => 2, 'orders' => 18, 'avg_amount' => 600], // فبراير
            ['month' => 3, 'orders' => 25, 'avg_amount' => 700], // مارس
            ['month' => 4, 'orders' => 30, 'avg_amount' => 800], // أبريل
            ['month' => 5, 'orders' => 35, 'avg_amount' => 900], // مايو
            ['month' => 6, 'orders' => 40, 'avg_amount' => 1000], // يونيو
            ['month' => 7, 'orders' => 45, 'avg_amount' => 1100], // يوليو
            ['month' => 8, 'orders' => 50, 'avg_amount' => 1200], // أغسطس
            ['month' => 9, 'orders' => 55, 'avg_amount' => 1300], // سبتمبر
            ['month' => 10, 'orders' => 60, 'avg_amount' => 1400], // أكتوبر
            ['month' => 11, 'orders' => 45, 'avg_amount' => 1200], // نوفمبر
            ['month' => 12, 'orders' => 35, 'avg_amount' => 1000], // ديسمبر
        ];
        
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $statusWeights = [0.15, 0.15, 0.15, 0.45, 0.1];
        
        $totalOrders = 0;
        
        foreach ($monthlyData as $monthData) {
            for ($i = 0; $i < $monthData['orders']; $i++) {
                $user = $users->random();
                $status = $this->getWeightedRandomStatus($statuses, $statusWeights);
                
                // Create random date within the month
                $day = rand(1, 28);
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $second = rand(0, 59);
                
                $orderDate = Carbon::create(2024, $monthData['month'], $day, $hour, $minute, $second);
                
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '01000000000',
                    'billing_address' => 'عنوان الفوترة - ' . $user->name,
                    'shipping_address' => 'عنوان الشحن - ' . $user->name,
                    'status' => $status,
                    'subtotal' => 0,
                    'tax_amount' => 0,
                    'shipping_amount' => 0,
                    'total_amount' => 0,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
                
                // Create order items with target amount
                $targetAmount = $monthData['avg_amount'] + rand(-200, 200);
                $itemsCount = rand(1, 4);
                $subtotal = 0;
                
                for ($j = 0; $j < $itemsCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 2);
                    $price = $product->sale_price ?? $product->price;
                    
                    // Adjust price to reach target amount
                    if ($j === $itemsCount - 1 && $itemsCount > 1) {
                        $remainingAmount = $targetAmount - $subtotal;
                        $price = max($remainingAmount / $quantity, $price * 0.5);
                    }
                    
                    $itemTotal = $price * $quantity;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                    ]);
                    
                    $subtotal += $itemTotal;
                }
                
                // Calculate tax and total
                $taxAmount = $subtotal * 0.1;
                $shippingAmount = rand(20, 50);
                $totalAmount = $subtotal + $taxAmount + $shippingAmount;
                
                $order->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $totalAmount,
                ]);
                
                $totalOrders++;
            }
        }
        
        echo "Created $totalOrders additional orders for 2024\n";
    }
    
    private function createPreviousYearOrders()
    {
        $users = User::all();
        $products = Product::all();
        
        // Create orders for 2023 with lower amounts for comparison
        $monthlyData = [
            ['month' => 1, 'orders' => 8, 'avg_amount' => 300], // يناير
            ['month' => 2, 'orders' => 10, 'avg_amount' => 350], // فبراير
            ['month' => 3, 'orders' => 12, 'avg_amount' => 400], // مارس
            ['month' => 4, 'orders' => 15, 'avg_amount' => 450], // أبريل
            ['month' => 5, 'orders' => 18, 'avg_amount' => 500], // مايو
            ['month' => 6, 'orders' => 20, 'avg_amount' => 550], // يونيو
            ['month' => 7, 'orders' => 22, 'avg_amount' => 600], // يوليو
            ['month' => 8, 'orders' => 25, 'avg_amount' => 650], // أغسطس
            ['month' => 9, 'orders' => 28, 'avg_amount' => 700], // سبتمبر
            ['month' => 10, 'orders' => 30, 'avg_amount' => 750], // أكتوبر
            ['month' => 11, 'orders' => 25, 'avg_amount' => 700], // نوفمبر
            ['month' => 12, 'orders' => 20, 'avg_amount' => 650], // ديسمبر
        ];
        
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $statusWeights = [0.1, 0.1, 0.1, 0.6, 0.1]; // More delivered orders for previous year
        
        $totalOrders = 0;
        
        foreach ($monthlyData as $monthData) {
            for ($i = 0; $i < $monthData['orders']; $i++) {
                $user = $users->random();
                $status = $this->getWeightedRandomStatus($statuses, $statusWeights);
                
                // Create random date within the month
                $day = rand(1, 28);
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $second = rand(0, 59);
                
                $orderDate = Carbon::create(2023, $monthData['month'], $day, $hour, $minute, $second);
                
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '01000000000',
                    'billing_address' => 'عنوان الفوترة - ' . $user->name,
                    'shipping_address' => 'عنوان الشحن - ' . $user->name,
                    'status' => $status,
                    'subtotal' => 0,
                    'tax_amount' => 0,
                    'shipping_amount' => 0,
                    'total_amount' => 0,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
                
                // Create order items with target amount
                $targetAmount = $monthData['avg_amount'] + rand(-100, 100);
                $itemsCount = rand(1, 3);
                $subtotal = 0;
                
                for ($j = 0; $j < $itemsCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 2);
                    $price = $product->sale_price ?? $product->price;
                    
                    // Adjust price to reach target amount
                    if ($j === $itemsCount - 1 && $itemsCount > 1) {
                        $remainingAmount = $targetAmount - $subtotal;
                        $price = max($remainingAmount / $quantity, $price * 0.5);
                    }
                    
                    $itemTotal = $price * $quantity;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                    ]);
                    
                    $subtotal += $itemTotal;
                }
                
                // Calculate tax and total
                $taxAmount = $subtotal * 0.1;
                $shippingAmount = rand(15, 40);
                $totalAmount = $subtotal + $taxAmount + $shippingAmount;
                
                $order->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $totalAmount,
                ]);
                
                $totalOrders++;
            }
        }
        
        echo "Created $totalOrders orders for 2023 (previous year)\n";
    }
    
    private function getWeightedRandomStatus($statuses, $weights)
    {
        $rand = mt_rand() / mt_getrandmax();
        $cumulative = 0;
        
        for ($i = 0; $i < count($statuses); $i++) {
            $cumulative += $weights[$i];
            if ($rand <= $cumulative) {
                return $statuses[$i];
            }
        }
        
        return $statuses[0];
    }
}