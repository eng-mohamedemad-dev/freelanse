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
        Schema::table('products', function (Blueprint $table) {
            // Remove unused fields (only existing ones)
            $table->dropColumn([
                'sku',
                'brand_id',
                'featured',
                'low_stock_threshold',
                'meta_title',
                'meta_description'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add back the removed fields
            $table->string('sku')->unique()->after('sale_price');
            $table->foreignId('brand_id')->nullable()->constrained()->after('category_id');
            $table->text('short_description')->nullable()->after('description');
            $table->string('slug')->unique()->after('name');
            $table->boolean('featured')->default(false)->after('status');
            $table->enum('stock_status', ['instock', 'outofstock'])->default('instock')->after('stock_quantity');
            $table->integer('low_stock_threshold')->default(5)->after('stock_status');
            $table->string('meta_title')->nullable()->after('low_stock_threshold');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }
};