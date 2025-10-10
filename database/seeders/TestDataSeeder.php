<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $this->createTestUsers();
        
        // Create test categories
        $this->createTestCategories();
        
        // Create test products
        $this->createTestProducts();
        
        // Create test orders with different dates for chart testing
        $this->createTestOrders();
    }
    
    private function createTestUsers()
    {
        $users = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@test.com', 'phone' => '01012345678'],
            ['name' => 'فاطمة علي', 'email' => 'fatima@test.com', 'phone' => '01012345679'],
            ['name' => 'محمد أحمد', 'email' => 'mohamed@test.com', 'phone' => '01012345680'],
            ['name' => 'سارة محمود', 'email' => 'sara@test.com', 'phone' => '01012345681'],
            ['name' => 'علي حسن', 'email' => 'ali@test.com', 'phone' => '01012345682'],
            ['name' => 'نور الدين', 'email' => 'nour@test.com', 'phone' => '01012345683'],
            ['name' => 'مريم سعد', 'email' => 'mariam@test.com', 'phone' => '01012345684'],
            ['name' => 'خالد عبدالله', 'email' => 'khalid@test.com', 'phone' => '01012345685'],
            ['name' => 'لينا أحمد', 'email' => 'lina@test.com', 'phone' => '01012345686'],
            ['name' => 'يوسف محمد', 'email' => 'youssef@test.com', 'phone' => '01012345687'],
            ['name' => 'رانيا علي', 'email' => 'rania@test.com', 'phone' => '01012345688'],
            ['name' => 'طارق محمود', 'email' => 'tarek@test.com', 'phone' => '01012345689'],
            ['name' => 'هند أحمد', 'email' => 'hind@test.com', 'phone' => '01012345690'],
            ['name' => 'عمر حسن', 'email' => 'omar@test.com', 'phone' => '01012345691'],
            ['name' => 'زينب محمد', 'email' => 'zeinab@test.com', 'phone' => '01012345692'],
        ];
        
        $created = 0;
        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]);
                $created++;
            }
        }
        
        echo "Created $created new test users\n";
    }
    
    private function createTestCategories()
    {
        $categories = [
            ['name' => 'إلكترونيات', 'description' => 'أجهزة إلكترونية متنوعة'],
            ['name' => 'ملابس', 'description' => 'ملابس رجالية ونسائية'],
            ['name' => 'أثاث', 'description' => 'أثاث منزلي ومكتبي'],
            ['name' => 'كتب', 'description' => 'كتب تعليمية وترفيهية'],
            ['name' => 'رياضة', 'description' => 'معدات وأدوات رياضية'],
            ['name' => 'جمال', 'description' => 'منتجات العناية والجمال'],
            ['name' => 'منزل', 'description' => 'أدوات منزلية'],
            ['name' => 'سيارات', 'description' => 'قطع غيار وإكسسوارات سيارات'],
            ['name' => 'أطفال', 'description' => 'منتجات للأطفال'],
            ['name' => 'طعام', 'description' => 'مواد غذائية'],
            ['name' => 'صحة', 'description' => 'منتجات صحية وطبية'],
            ['name' => 'حديقة', 'description' => 'نباتات وأدوات حديقة'],
            ['name' => 'مكتب', 'description' => 'أدوات مكتبية'],
            ['name' => 'سفر', 'description' => 'حقائب وأدوات سفر'],
            ['name' => 'حيوانات', 'description' => 'منتجات للحيوانات الأليفة'],
        ];
        
        $created = 0;
        foreach ($categories as $categoryData) {
            if (!Category::where('name', $categoryData['name'])->exists()) {
                Category::create([
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'status' => 'active',
                ]);
                $created++;
            }
        }
        
        echo "Created $created new test categories\n";
    }
    
    private function createTestProducts()
    {
        $categories = Category::all();
        
        $products = [
            // إلكترونيات
            ['name' => 'هاتف ذكي سامسونج', 'description' => 'هاتف ذكي بمواصفات عالية', 'price' => 2500, 'sale_price' => 2200, 'stock' => 50],
            ['name' => 'لابتوب ديل', 'description' => 'لابتوب للأعمال والدراسة', 'price' => 4500, 'sale_price' => 4000, 'stock' => 30],
            ['name' => 'سماعات لاسلكية', 'description' => 'سماعات عالية الجودة', 'price' => 300, 'sale_price' => 250, 'stock' => 100],
            ['name' => 'كاميرا كانون', 'description' => 'كاميرا احترافية للتصوير', 'price' => 3500, 'sale_price' => 3200, 'stock' => 20],
            ['name' => 'تابلت آيباد', 'description' => 'تابلت للعمل والترفيه', 'price' => 2000, 'sale_price' => 1800, 'stock' => 40],
            
            // ملابس
            ['name' => 'قميص قطني', 'description' => 'قميص قطني مريح', 'price' => 150, 'sale_price' => 120, 'stock' => 200],
            ['name' => 'بنطلون جينز', 'description' => 'بنطلون جينز عالي الجودة', 'price' => 300, 'sale_price' => 250, 'stock' => 150],
            ['name' => 'فستان نسائي', 'description' => 'فستان أنيق للمناسبات', 'price' => 400, 'sale_price' => 350, 'stock' => 80],
            ['name' => 'جاكيت شتوي', 'description' => 'جاكيت دافئ للشتاء', 'price' => 500, 'sale_price' => 450, 'stock' => 60],
            ['name' => 'حذاء رياضي', 'description' => 'حذاء رياضي مريح', 'price' => 250, 'sale_price' => 200, 'stock' => 120],
            
            // أثاث
            ['name' => 'طاولة مكتب', 'description' => 'طاولة مكتب خشبية', 'price' => 800, 'sale_price' => 700, 'stock' => 25],
            ['name' => 'كرسي مكتب', 'description' => 'كرسي مكتب مريح', 'price' => 400, 'sale_price' => 350, 'stock' => 40],
            ['name' => 'سرير مفرد', 'description' => 'سرير مفرد خشبي', 'price' => 1200, 'sale_price' => 1000, 'stock' => 15],
            ['name' => 'دولاب ملابس', 'description' => 'دولاب ملابس كبير', 'price' => 1500, 'sale_price' => 1300, 'stock' => 10],
            ['name' => 'كنبة ثلاثية', 'description' => 'كنبة مريحة للجلوس', 'price' => 2000, 'sale_price' => 1800, 'stock' => 8],
            
            // كتب
            ['name' => 'كتاب البرمجة', 'description' => 'كتاب تعليم البرمجة', 'price' => 100, 'sale_price' => 80, 'stock' => 300],
            ['name' => 'رواية عربية', 'description' => 'رواية أدبية عربية', 'price' => 50, 'sale_price' => 40, 'stock' => 500],
            ['name' => 'قاموس إنجليزي', 'description' => 'قاموس إنجليزي عربي', 'price' => 80, 'sale_price' => 70, 'stock' => 200],
            ['name' => 'كتاب الطبخ', 'description' => 'كتاب وصفات الطبخ', 'price' => 60, 'sale_price' => 50, 'stock' => 250],
            ['name' => 'موسوعة علمية', 'description' => 'موسوعة العلوم', 'price' => 200, 'sale_price' => 180, 'stock' => 100],
            
            // رياضة
            ['name' => 'كرة قدم', 'description' => 'كرة قدم احترافية', 'price' => 150, 'sale_price' => 120, 'stock' => 100],
            ['name' => 'مضرب تنس', 'description' => 'مضرب تنس عالي الجودة', 'price' => 300, 'sale_price' => 250, 'stock' => 50],
            ['name' => 'دراجة هوائية', 'description' => 'دراجة هوائية للرياضة', 'price' => 1500, 'sale_price' => 1300, 'stock' => 20],
            ['name' => 'حذاء كرة قدم', 'description' => 'حذاء كرة قدم احترافي', 'price' => 400, 'sale_price' => 350, 'stock' => 80],
            ['name' => 'معدات جيم', 'description' => 'معدات تمارين منزلية', 'price' => 800, 'sale_price' => 700, 'stock' => 30],
        ];
        
        $created = 0;
        foreach ($products as $index => $productData) {
            if (!Product::where('name', $productData['name'])->exists()) {
                $category = $categories[$index % $categories->count()];
                
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'category_id' => $category->id,
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'],
                    'stock' => $productData['stock'],
                    'status' => 'active',
                ]);
                $created++;
            }
        }
        
        echo "Created $created new test products\n";
    }
    
    private function createTestOrders()
    {
        $users = User::all();
        $products = Product::all();
        
        // Create orders for different months to test the chart
        $months = [
            ['month' => 1, 'year' => 2024, 'orders' => 5], // يناير
            ['month' => 2, 'year' => 2024, 'orders' => 8], // فبراير
            ['month' => 3, 'year' => 2024, 'orders' => 12], // مارس
            ['month' => 4, 'year' => 2024, 'orders' => 15], // أبريل
            ['month' => 5, 'year' => 2024, 'orders' => 18], // مايو
            ['month' => 6, 'year' => 2024, 'orders' => 22], // يونيو
            ['month' => 7, 'year' => 2024, 'orders' => 25], // يوليو
            ['month' => 8, 'year' => 2024, 'orders' => 28], // أغسطس
            ['month' => 9, 'year' => 2024, 'orders' => 30], // سبتمبر
            ['month' => 10, 'year' => 2024, 'orders' => 35], // أكتوبر
            ['month' => 11, 'year' => 2024, 'orders' => 20], // نوفمبر
            ['month' => 12, 'year' => 2024, 'orders' => 15], // ديسمبر
        ];
        
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $statusWeights = [0.2, 0.15, 0.15, 0.4, 0.1]; // احتمالات الحالات
        
        $totalOrders = 0;
        
        foreach ($months as $monthData) {
            for ($i = 0; $i < $monthData['orders']; $i++) {
                $user = $users->random();
                $status = $this->getWeightedRandomStatus($statuses, $statusWeights);
                
                // Create random date within the month
                $day = rand(1, 28);
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $second = rand(0, 59);
                
                $orderDate = Carbon::create($monthData['year'], $monthData['month'], $day, $hour, $minute, $second);
                
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad($totalOrders + 1, 6, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '01000000000',
                    'billing_address' => 'عنوان الفوترة - ' . $user->name,
                    'shipping_address' => 'عنوان الشحن - ' . $user->name,
                    'status' => $status,
                    'subtotal' => 0, // Will be calculated
                    'tax_amount' => 0,
                    'shipping_amount' => 0,
                    'total_amount' => 0, // Will be calculated
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
                
                // Create order items
                $itemsCount = rand(1, 5);
                $subtotal = 0;
                
                for ($j = 0; $j < $itemsCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->sale_price ?? $product->price;
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
                $taxAmount = $subtotal * 0.1; // 10% tax
                $shippingAmount = rand(20, 50);
                $totalAmount = $subtotal + $taxAmount + $shippingAmount;
                
                // Update order with calculated amounts
                $order->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $totalAmount,
                ]);
                
                $totalOrders++;
            }
        }
        
        echo "Created $totalOrders test orders across different months\n";
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