<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // تحديث حقل role ليشمل القيم الجديدة
            $table->enum('role', ['admin', 'manager', 'user', 'customer'])->default('user')->change();
        });
        
        // تحديث البيانات الموجودة
        \DB::statement("UPDATE users SET role = 'user' WHERE role = 'customer'");
        
        Schema::table('users', function (Blueprint $table) {
            // إزالة قيمة customer من الـ enum
            $table->enum('role', ['admin', 'manager', 'user'])->default('user')->change();
            $table->boolean('is_active')->default(true)->after('role'); // حالة المستخدم
            $table->timestamp('last_login_at')->nullable()->after('is_active'); // آخر تسجيل دخول
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // تحديث البيانات قبل إرجاع الـ enum
        \DB::statement("UPDATE users SET role = 'customer' WHERE role IN ('user', 'manager')");
        
        Schema::table('users', function (Blueprint $table) {
            // إرجاع حقل role للقيم الأصلية
            $table->enum('role', ['admin', 'customer'])->default('customer')->change();
            $table->dropColumn(['is_active', 'last_login_at']);
        });
    }
};
