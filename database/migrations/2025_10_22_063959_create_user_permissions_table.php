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
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // معرف المستخدم
            $table->foreignId('permission_id')->constrained()->onDelete('cascade'); // معرف الصلاحية
            $table->boolean('is_granted')->default(true); // هل الصلاحية ممنوحة أم لا
            $table->timestamp('granted_at')->nullable(); // تاريخ منح الصلاحية
            $table->timestamp('revoked_at')->nullable(); // تاريخ إلغاء الصلاحية
            $table->timestamps();
            
            // فهرس فريد لمنع التكرار
            $table->unique(['user_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
