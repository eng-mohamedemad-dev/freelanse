<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الادمن الافتراضي
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // إنشاء مستخدم تجريبي
        User::create([
            'name' => 'Test User',
            'email' => 'user@ecommerce.com',
            'password' => Hash::make('user123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
