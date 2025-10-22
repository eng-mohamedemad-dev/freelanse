<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name' => 'مدير النظام',
                'password' => bcrypt('123456789'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // منح جميع الصلاحيات للمدير
        $allPermissions = Permission::all();
        foreach ($allPermissions as $permission) {
            $admin->grantPermission($permission);
        }

        // إنشاء مستخدم Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@ecommerce.com'],
            [
                'name' => 'مدير فرعي',
                'password' => bcrypt('123456789'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );

        // منح صلاحيات محدودة للمدير الفرعي
        $managerPermissions = [
            'view_products', 'create_products', 'edit_products',
            'view_orders', 'update_order_status',
            'view_categories', 'create_categories', 'edit_categories',
            'view_coupons', 'create_coupons', 'edit_coupons',
            'view_users', 'edit_users',
            'view_statistics'
        ];

        foreach ($managerPermissions as $permissionSlug) {
            $permission = Permission::where('slug', $permissionSlug)->first();
            if ($permission) {
                $manager->grantPermission($permission);
            }
        }

        // إنشاء مستخدم User
        $user = User::firstOrCreate(
            ['email' => 'user@ecommerce.com'],
            [
                'name' => 'مستخدم عادي',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'is_active' => true,
            ]
        );

        // منح صلاحيات أساسية للمستخدم العادي
        $userPermissions = [
            'view_products',
            'view_orders',
            'view_categories',
            'view_coupons',
            'view_statistics'
        ];

        foreach ($userPermissions as $permissionSlug) {
            $permission = Permission::where('slug', $permissionSlug)->first();
            if ($permission) {
                $user->grantPermission($permission);
            }
        }

        $this->command->info('تم إنشاء المستخدمين بنجاح:');
        $this->command->info('Admin: admin@ecommerce.com / 123456789');
        $this->command->info('Manager: manager@ecommerce.com / 123456789');
        $this->command->info('User: user@ecommerce.com / 123456789');
    }
}
