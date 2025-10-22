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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الصلاحية
            $table->string('name_ar'); // اسم الصلاحية بالعربية
            $table->string('name_en'); // اسم الصلاحية بالإنجليزية
            $table->string('slug')->unique(); // معرف فريد للصلاحية
            $table->text('description_ar')->nullable(); // وصف الصلاحية بالعربية
            $table->text('description_en')->nullable(); // وصف الصلاحية بالإنجليزية
            $table->string('category')->default('general'); // فئة الصلاحية
            $table->boolean('is_active')->default(true); // حالة الصلاحية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
