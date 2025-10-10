<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class AdditionalTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional users for pagination testing
        $this->createAdditionalUsers();
        
        // Create additional categories for pagination testing
        $this->createAdditionalCategories();
        
        // Create additional products for pagination testing
        $this->createAdditionalProducts();
    }
    
    private function createAdditionalUsers()
    {
        $users = [
            ['name' => 'أميرة أحمد', 'email' => 'amira@test.com', 'phone' => '01012345693'],
            ['name' => 'باسم محمد', 'email' => 'basem@test.com', 'phone' => '01012345694'],
            ['name' => 'دينا علي', 'email' => 'dina@test.com', 'phone' => '01012345695'],
            ['name' => 'إيهاب حسن', 'email' => 'ehab@test.com', 'phone' => '01012345696'],
            ['name' => 'فادي محمود', 'email' => 'fadi@test.com', 'phone' => '01012345697'],
            ['name' => 'غادة سعد', 'email' => 'ghada@test.com', 'phone' => '01012345698'],
            ['name' => 'هشام عبدالله', 'email' => 'hesham@test.com', 'phone' => '01012345699'],
            ['name' => 'إيمان أحمد', 'email' => 'iman@test.com', 'phone' => '01012345700'],
            ['name' => 'جمال محمد', 'email' => 'gamal@test.com', 'phone' => '01012345701'],
            ['name' => 'كرم علي', 'email' => 'karam@test.com', 'phone' => '01012345702'],
            ['name' => 'ليلى حسن', 'email' => 'layla@test.com', 'phone' => '01012345703'],
            ['name' => 'محمود سعد', 'email' => 'mahmoud@test.com', 'phone' => '01012345704'],
            ['name' => 'نادية محمود', 'email' => 'nadia@test.com', 'phone' => '01012345705'],
            ['name' => 'وسام عبدالله', 'email' => 'wessam@test.com', 'phone' => '01012345706'],
            ['name' => 'ياسر أحمد', 'email' => 'yasser@test.com', 'phone' => '01012345707'],
            ['name' => 'زينب محمد', 'email' => 'zeinab2@test.com', 'phone' => '01012345708'],
            ['name' => 'أحمد علي', 'email' => 'ahmed2@test.com', 'phone' => '01012345709'],
            ['name' => 'بسمة حسن', 'email' => 'basma@test.com', 'phone' => '01012345710'],
            ['name' => 'تامر سعد', 'email' => 'tamer@test.com', 'phone' => '01012345711'],
            ['name' => 'جيهان محمود', 'email' => 'gehan@test.com', 'phone' => '01012345712'],
            ['name' => 'حسام عبدالله', 'email' => 'hossam@test.com', 'phone' => '01012345713'],
            ['name' => 'رانيا أحمد', 'email' => 'rania2@test.com', 'phone' => '01012345714'],
            ['name' => 'سامي محمد', 'email' => 'samy@test.com', 'phone' => '01012345715'],
            ['name' => 'علا علي', 'email' => 'ola@test.com', 'phone' => '01012345716'],
            ['name' => 'فريد حسن', 'email' => 'farid@test.com', 'phone' => '01012345717'],
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
        
        echo "Created $created additional test users\n";
    }
    
    private function createAdditionalCategories()
    {
        $categories = [
            ['name' => 'ألعاب', 'description' => 'ألعاب أطفال وبالغين'],
            ['name' => 'موسيقى', 'description' => 'آلات موسيقية وملحقات'],
            ['name' => 'فن', 'description' => 'لوحات وأدوات فنية'],
            ['name' => 'تصوير', 'description' => 'معدات التصوير والإضاءة'],
            ['name' => 'طبخ', 'description' => 'أدوات الطبخ والمطبخ'],
            ['name' => 'تنظيف', 'description' => 'منتجات التنظيف والعناية'],
            ['name' => 'إضاءة', 'description' => 'مصابيح وإضاءة منزلية'],
            ['name' => 'ديكور', 'description' => 'عناصر الديكور والتزيين'],
            ['name' => 'أمان', 'description' => 'أنظمة الأمان والحماية'],
            ['name' => 'اتصالات', 'description' => 'أجهزة الاتصالات والشبكات'],
            ['name' => 'طاقة', 'description' => 'مصادر الطاقة البديلة'],
            ['name' => 'مياه', 'description' => 'أنظمة المياه والري'],
            ['name' => 'هواء', 'description' => 'أنظمة التكييف والتهوية'],
            ['name' => 'نقل', 'description' => 'وسائل النقل والمواصلات'],
            ['name' => 'تعليم', 'description' => 'مواد وأدوات تعليمية'],
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
        
        echo "Created $created additional test categories\n";
    }
    
    private function createAdditionalProducts()
    {
        $categories = Category::all();
        
        $products = [
            // ألعاب
            ['name' => 'لعبة بلاي ستيشن', 'description' => 'لعبة ألعاب إلكترونية', 'price' => 200, 'sale_price' => 180, 'stock' => 50],
            ['name' => 'لعبة أطفال تعليمية', 'description' => 'لعبة تعليمية للأطفال', 'price' => 80, 'sale_price' => 70, 'stock' => 100],
            ['name' => 'لعبة ألغاز', 'description' => 'لعبة ألغاز ذهنية', 'price' => 60, 'sale_price' => 50, 'stock' => 150],
            ['name' => 'لعبة كرة قدم طاولة', 'description' => 'لعبة كرة قدم للطاولة', 'price' => 300, 'sale_price' => 250, 'stock' => 30],
            ['name' => 'لعبة شطرنج', 'description' => 'لعبة شطرنج خشبية', 'price' => 120, 'sale_price' => 100, 'stock' => 80],
            
            // موسيقى
            ['name' => 'جيتار كهربائي', 'description' => 'جيتار كهربائي احترافي', 'price' => 1500, 'sale_price' => 1300, 'stock' => 15],
            ['name' => 'بيانو رقمي', 'description' => 'بيانو رقمي للمبتدئين', 'price' => 2000, 'sale_price' => 1800, 'stock' => 10],
            ['name' => 'طبلة عربية', 'description' => 'طبلة عربية تقليدية', 'price' => 400, 'sale_price' => 350, 'stock' => 25],
            ['name' => 'ميكروفون احترافي', 'description' => 'ميكروفون للغناء', 'price' => 600, 'sale_price' => 500, 'stock' => 40],
            ['name' => 'سماعات موسيقية', 'description' => 'سماعات للموسيقيين', 'price' => 800, 'sale_price' => 700, 'stock' => 35],
            
            // فن
            ['name' => 'لوحة فنية', 'description' => 'لوحة فنية زيتية', 'price' => 500, 'sale_price' => 450, 'stock' => 20],
            ['name' => 'ألوان زيتية', 'description' => 'مجموعة ألوان زيتية', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'فرشاة رسم', 'description' => 'فرشاة رسم احترافية', 'price' => 50, 'sale_price' => 40, 'stock' => 200],
            ['name' => 'كانفاس رسم', 'description' => 'كانفاس للرسم', 'price' => 80, 'sale_price' => 70, 'stock' => 100],
            ['name' => 'إطار لوحة', 'description' => 'إطار خشبي للوحات', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            
            // تصوير
            ['name' => 'عدسة كاميرا', 'description' => 'عدسة احترافية للكاميرا', 'price' => 1200, 'sale_price' => 1000, 'stock' => 25],
            ['name' => 'حامل كاميرا', 'description' => 'حامل ثلاثي للكاميرا', 'price' => 300, 'sale_price' => 250, 'stock' => 50],
            ['name' => 'فلاش كاميرا', 'description' => 'فلاش احترافي', 'price' => 400, 'sale_price' => 350, 'stock' => 40],
            ['name' => 'حقيبة كاميرا', 'description' => 'حقيبة حماية للكاميرا', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'بطارية كاميرا', 'description' => 'بطارية احتياطية', 'price' => 100, 'sale_price' => 80, 'stock' => 100],
            
            // طبخ
            ['name' => 'طنجرة ضغط', 'description' => 'طنجرة ضغط عالية الجودة', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'مقلاة غير لاصقة', 'description' => 'مقلاة تيفال', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'خلاط كهربائي', 'description' => 'خلاط قوي للمطبخ', 'price' => 400, 'sale_price' => 350, 'stock' => 30],
            ['name' => 'فرن كهربائي', 'description' => 'فرن كهربائي صغير', 'price' => 500, 'sale_price' => 450, 'stock' => 25],
            ['name' => 'مجموعة سكاكين', 'description' => 'مجموعة سكاكين احترافية', 'price' => 250, 'sale_price' => 200, 'stock' => 50],
            
            // تنظيف
            ['name' => 'مكنسة كهربائية', 'description' => 'مكنسة كهربائية قوية', 'price' => 600, 'sale_price' => 500, 'stock' => 35],
            ['name' => 'منظف أرضيات', 'description' => 'منظف للأرضيات', 'price' => 50, 'sale_price' => 40, 'stock' => 200],
            ['name' => 'ممسحة بخار', 'description' => 'ممسحة بخار للتنظيف', 'price' => 400, 'sale_price' => 350, 'stock' => 30],
            ['name' => 'منظف زجاج', 'description' => 'منظف للزجاج والمرايا', 'price' => 30, 'sale_price' => 25, 'stock' => 300],
            ['name' => 'مطهر عام', 'description' => 'مطهر للأسطح', 'price' => 40, 'sale_price' => 35, 'stock' => 250],
            
            // إضاءة
            ['name' => 'مصباح LED', 'description' => 'مصباح LED موفر للطاقة', 'price' => 80, 'sale_price' => 70, 'stock' => 100],
            ['name' => 'ثريا فاخرة', 'description' => 'ثريا إضاءة للمنزل', 'price' => 800, 'sale_price' => 700, 'stock' => 15],
            ['name' => 'مصباح مكتب', 'description' => 'مصباح مكتبي LED', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            ['name' => 'إضاءة خارجية', 'description' => 'مصابيح للحديقة', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'إضاءة طوارئ', 'description' => 'مصباح طوارئ', 'price' => 100, 'sale_price' => 80, 'stock' => 90],
            
            // ديكور
            ['name' => 'سجادة فاخرة', 'description' => 'سجادة للصالة', 'price' => 600, 'sale_price' => 500, 'stock' => 20],
            ['name' => 'مرآة ديكور', 'description' => 'مرآة زخرفية', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'نباتات زينة', 'description' => 'نباتات للديكور', 'price' => 150, 'sale_price' => 120, 'stock' => 60],
            ['name' => 'شمعدان زجاجي', 'description' => 'شمعدان للديكور', 'price' => 200, 'sale_price' => 180, 'stock' => 50],
            ['name' => 'وسائد ديكور', 'description' => 'وسائد زخرفية', 'price' => 80, 'sale_price' => 70, 'stock' => 100],
            
            // أمان
            ['name' => 'كاميرا مراقبة', 'description' => 'كاميرا مراقبة IP', 'price' => 500, 'sale_price' => 450, 'stock' => 30],
            ['name' => 'جهاز إنذار', 'description' => 'جهاز إنذار للمنزل', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'قفل ذكي', 'description' => 'قفل ذكي للباب', 'price' => 400, 'sale_price' => 350, 'stock' => 25],
            ['name' => 'كاشف دخان', 'description' => 'كاشف دخان وحرائق', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            ['name' => 'مطفأة حريق', 'description' => 'مطفأة حريق صغيرة', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            
            // اتصالات
            ['name' => 'راوتر WiFi', 'description' => 'راوتر لاسلكي قوي', 'price' => 400, 'sale_price' => 350, 'stock' => 50],
            ['name' => 'مكبر صوت', 'description' => 'مكبر صوت لاسلكي', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'هاتف أرضي', 'description' => 'هاتف أرضي لاسلكي', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'شاحن لاسلكي', 'description' => 'شاحن لاسلكي للهاتف', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            ['name' => 'كابل USB', 'description' => 'كابل USB سريع', 'price' => 50, 'sale_price' => 40, 'stock' => 200],
            
            // طاقة
            ['name' => 'لوحة شمسية', 'description' => 'لوحة طاقة شمسية', 'price' => 2000, 'sale_price' => 1800, 'stock' => 10],
            ['name' => 'بطارية احتياطية', 'description' => 'بطارية قوية للطوارئ', 'price' => 500, 'sale_price' => 450, 'stock' => 30],
            ['name' => 'شاحن سيارة', 'description' => 'شاحن للسيارة', 'price' => 100, 'sale_price' => 80, 'stock' => 100],
            ['name' => 'محول كهرباء', 'description' => 'محول للجهد', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'كابل كهرباء', 'description' => 'كابل كهرباء طويل', 'price' => 80, 'sale_price' => 70, 'stock' => 120],
            
            // مياه
            ['name' => 'فلتر مياه', 'description' => 'فلتر تنقية المياه', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'خزان مياه', 'description' => 'خزان مياه صغير', 'price' => 200, 'sale_price' => 180, 'stock' => 50],
            ['name' => 'مضخة مياه', 'description' => 'مضخة مياه صغيرة', 'price' => 400, 'sale_price' => 350, 'stock' => 30],
            ['name' => 'خرطوم ري', 'description' => 'خرطوم للحديقة', 'price' => 100, 'sale_price' => 80, 'stock' => 80],
            ['name' => 'رشاش مياه', 'description' => 'رشاش للحديقة', 'price' => 150, 'sale_price' => 120, 'stock' => 60],
            
            // هواء
            ['name' => 'مكيف هواء', 'description' => 'مكيف هواء صغير', 'price' => 1500, 'sale_price' => 1300, 'stock' => 15],
            ['name' => 'مروحة سقف', 'description' => 'مروحة سقفية', 'price' => 400, 'sale_price' => 350, 'stock' => 25],
            ['name' => 'مروحة مكتب', 'description' => 'مروحة مكتبية صغيرة', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            ['name' => 'مرطب هواء', 'description' => 'مرطب للهواء الجاف', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'منقي هواء', 'description' => 'منقي للهواء', 'price' => 500, 'sale_price' => 450, 'stock' => 30],
            
            // نقل
            ['name' => 'دراجة نارية', 'description' => 'دراجة نارية صغيرة', 'price' => 8000, 'sale_price' => 7500, 'stock' => 5],
            ['name' => 'سكوتر كهربائي', 'description' => 'سكوتر كهربائي', 'price' => 2000, 'sale_price' => 1800, 'stock' => 10],
            ['name' => 'حقيبة سفر', 'description' => 'حقيبة سفر كبيرة', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'حقيبة يد', 'description' => 'حقيبة يد نسائية', 'price' => 200, 'sale_price' => 180, 'stock' => 60],
            ['name' => 'حقيبة ظهر', 'description' => 'حقيبة ظهر للطلاب', 'price' => 150, 'sale_price' => 120, 'stock' => 80],
            
            // تعليم
            ['name' => 'جهاز كمبيوتر', 'description' => 'جهاز كمبيوتر للطلاب', 'price' => 3000, 'sale_price' => 2800, 'stock' => 20],
            ['name' => 'طابعة', 'description' => 'طابعة للمنزل', 'price' => 800, 'sale_price' => 700, 'stock' => 25],
            ['name' => 'مكتب دراسة', 'description' => 'مكتب للدراسة', 'price' => 600, 'sale_price' => 500, 'stock' => 30],
            ['name' => 'كرسي دراسة', 'description' => 'كرسي مريح للدراسة', 'price' => 300, 'sale_price' => 250, 'stock' => 40],
            ['name' => 'مكتبة كتب', 'description' => 'مكتبة لحفظ الكتب', 'price' => 400, 'sale_price' => 350, 'stock' => 35],
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
        
        echo "Created $created additional test products\n";
    }
}