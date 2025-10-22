<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // صلاحيات إدارة المستخدمين
            [
                'name' => 'View Users',
                'name_ar' => 'عرض المستخدمين',
                'name_en' => 'View Users',
                'slug' => 'view_users',
                'description_ar' => 'إمكانية عرض قائمة المستخدمين',
                'description_en' => 'Ability to view users list',
                'category' => 'users'
            ],
            [
                'name' => 'Create Users',
                'name_ar' => 'إنشاء مستخدمين',
                'name_en' => 'Create Users',
                'slug' => 'create_users',
                'description_ar' => 'إمكانية إنشاء مستخدمين جدد',
                'description_en' => 'Ability to create new users',
                'category' => 'users'
            ],
            [
                'name' => 'Edit Users',
                'name_ar' => 'تعديل المستخدمين',
                'name_en' => 'Edit Users',
                'slug' => 'edit_users',
                'description_ar' => 'إمكانية تعديل بيانات المستخدمين',
                'description_en' => 'Ability to edit user data',
                'category' => 'users'
            ],
            [
                'name' => 'Delete Users',
                'name_ar' => 'حذف المستخدمين',
                'name_en' => 'Delete Users',
                'slug' => 'delete_users',
                'description_ar' => 'إمكانية حذف المستخدمين',
                'description_en' => 'Ability to delete users',
                'category' => 'users'
            ],
            [
                'name' => 'Manage User Permissions',
                'name_ar' => 'إدارة صلاحيات المستخدمين',
                'name_en' => 'Manage User Permissions',
                'slug' => 'manage_user_permissions',
                'description_ar' => 'إمكانية إدارة صلاحيات المستخدمين',
                'description_en' => 'Ability to manage user permissions',
                'category' => 'users'
            ],

            // صلاحيات إدارة المنتجات
            [
                'name' => 'View Products',
                'name_ar' => 'عرض المنتجات',
                'name_en' => 'View Products',
                'slug' => 'view_products',
                'description_ar' => 'إمكانية عرض قائمة المنتجات',
                'description_en' => 'Ability to view products list',
                'category' => 'products'
            ],
            [
                'name' => 'Create Products',
                'name_ar' => 'إنشاء منتجات',
                'name_en' => 'Create Products',
                'slug' => 'create_products',
                'description_ar' => 'إمكانية إنشاء منتجات جديدة',
                'description_en' => 'Ability to create new products',
                'category' => 'products'
            ],
            [
                'name' => 'Edit Products',
                'name_ar' => 'تعديل المنتجات',
                'name_en' => 'Edit Products',
                'slug' => 'edit_products',
                'description_ar' => 'إمكانية تعديل بيانات المنتجات',
                'description_en' => 'Ability to edit product data',
                'category' => 'products'
            ],
            [
                'name' => 'Delete Products',
                'name_ar' => 'حذف المنتجات',
                'name_en' => 'Delete Products',
                'slug' => 'delete_products',
                'description_ar' => 'إمكانية حذف المنتجات',
                'description_en' => 'Ability to delete products',
                'category' => 'products'
            ],

            // صلاحيات إدارة الطلبات
            [
                'name' => 'View Orders',
                'name_ar' => 'عرض الطلبات',
                'name_en' => 'View Orders',
                'slug' => 'view_orders',
                'description_ar' => 'إمكانية عرض قائمة الطلبات',
                'description_en' => 'Ability to view orders list',
                'category' => 'orders'
            ],
            [
                'name' => 'Update Order Status',
                'name_ar' => 'تحديث حالة الطلب',
                'name_en' => 'Update Order Status',
                'slug' => 'update_order_status',
                'description_ar' => 'إمكانية تحديث حالة الطلبات',
                'description_en' => 'Ability to update order status',
                'category' => 'orders'
            ],

            // صلاحيات إدارة الفئات
            [
                'name' => 'View Categories',
                'name_ar' => 'عرض الفئات',
                'name_en' => 'View Categories',
                'slug' => 'view_categories',
                'description_ar' => 'إمكانية عرض قائمة الفئات',
                'description_en' => 'Ability to view categories list',
                'category' => 'categories'
            ],
            [
                'name' => 'Create Categories',
                'name_ar' => 'إنشاء فئات',
                'name_en' => 'Create Categories',
                'slug' => 'create_categories',
                'description_ar' => 'إمكانية إنشاء فئات جديدة',
                'description_en' => 'Ability to create new categories',
                'category' => 'categories'
            ],
            [
                'name' => 'Edit Categories',
                'name_ar' => 'تعديل الفئات',
                'name_en' => 'Edit Categories',
                'slug' => 'edit_categories',
                'description_ar' => 'إمكانية تعديل بيانات الفئات',
                'description_en' => 'Ability to edit category data',
                'category' => 'categories'
            ],
            [
                'name' => 'Delete Categories',
                'name_ar' => 'حذف الفئات',
                'name_en' => 'Delete Categories',
                'slug' => 'delete_categories',
                'description_ar' => 'إمكانية حذف الفئات',
                'description_en' => 'Ability to delete categories',
                'category' => 'categories'
            ],

            // صلاحيات إدارة الكوبونات
            [
                'name' => 'View Coupons',
                'name_ar' => 'عرض الكوبونات',
                'name_en' => 'View Coupons',
                'slug' => 'view_coupons',
                'description_ar' => 'إمكانية عرض قائمة الكوبونات',
                'description_en' => 'Ability to view coupons list',
                'category' => 'coupons'
            ],
            [
                'name' => 'Create Coupons',
                'name_ar' => 'إنشاء كوبونات',
                'name_en' => 'Create Coupons',
                'slug' => 'create_coupons',
                'description_ar' => 'إمكانية إنشاء كوبونات جديدة',
                'description_en' => 'Ability to create new coupons',
                'category' => 'coupons'
            ],
            [
                'name' => 'Edit Coupons',
                'name_ar' => 'تعديل الكوبونات',
                'name_en' => 'Edit Coupons',
                'slug' => 'edit_coupons',
                'description_ar' => 'إمكانية تعديل بيانات الكوبونات',
                'description_en' => 'Ability to edit coupon data',
                'category' => 'coupons'
            ],
            [
                'name' => 'Delete Coupons',
                'name_ar' => 'حذف الكوبونات',
                'name_en' => 'Delete Coupons',
                'slug' => 'delete_coupons',
                'description_ar' => 'إمكانية حذف الكوبونات',
                'description_en' => 'Ability to delete coupons',
                'category' => 'coupons'
            ],

            // صلاحيات إدارة الإعدادات
            [
                'name' => 'View Settings',
                'name_ar' => 'عرض الإعدادات',
                'name_en' => 'View Settings',
                'slug' => 'view_settings',
                'description_ar' => 'إمكانية عرض الإعدادات',
                'description_en' => 'Ability to view settings',
                'category' => 'settings'
            ],
            [
                'name' => 'Update Settings',
                'name_ar' => 'تحديث الإعدادات',
                'name_en' => 'Update Settings',
                'slug' => 'update_settings',
                'description_ar' => 'إمكانية تحديث الإعدادات',
                'description_en' => 'Ability to update settings',
                'category' => 'settings'
            ],

            // صلاحيات إدارة الإحصائيات
            [
                'name' => 'View Statistics',
                'name_ar' => 'عرض الإحصائيات',
                'name_en' => 'View Statistics',
                'slug' => 'view_statistics',
                'description_ar' => 'إمكانية عرض الإحصائيات والتقارير',
                'description_en' => 'Ability to view statistics and reports',
                'category' => 'statistics'
            ],

            // صلاحيات إدارة الإشعارات
            [
                'name' => 'View Notifications',
                'name_ar' => 'عرض الإشعارات',
                'name_en' => 'View Notifications',
                'slug' => 'view_notifications',
                'description_ar' => 'إمكانية عرض الإشعارات',
                'description_en' => 'Ability to view notifications',
                'category' => 'notifications'
            ],
            [
                'name' => 'Send Notifications',
                'name_ar' => 'إرسال إشعارات',
                'name_en' => 'Send Notifications',
                'slug' => 'send_notifications',
                'description_ar' => 'إمكانية إرسال إشعارات للمستخدمين',
                'description_en' => 'Ability to send notifications to users',
                'category' => 'notifications'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
