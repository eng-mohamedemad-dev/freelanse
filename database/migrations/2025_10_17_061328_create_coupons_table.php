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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // كود الكوبون
            $table->string('name_ar')->nullable(); // الاسم بالعربية
            $table->string('name_en')->nullable(); // الاسم بالإنجليزية
            $table->text('description_ar')->nullable(); // الوصف بالعربية
            $table->text('description_en')->nullable(); // الوصف بالإنجليزية
            $table->enum('type', ['fixed', 'percentage']); // نوع الخصم: مبلغ ثابت أو نسبة مئوية
            $table->decimal('value', 10, 2); // قيمة الخصم
            $table->decimal('minimum_amount', 10, 2)->nullable(); // الحد الأدنى للطلب
            $table->decimal('maximum_discount', 10, 2)->nullable(); // الحد الأقصى للخصم
            $table->integer('usage_limit')->nullable(); // حد الاستخدام
            $table->integer('used_count')->default(0); // عدد مرات الاستخدام
            $table->date('starts_at')->nullable(); // تاريخ بداية الكوبون
            $table->date('expires_at')->nullable(); // تاريخ انتهاء الكوبون
            $table->string('image')->nullable(); // صورة الكوبون
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الكوبون
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
