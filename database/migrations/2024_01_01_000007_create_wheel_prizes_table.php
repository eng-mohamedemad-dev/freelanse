<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wheel_prizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['discount', 'points', 'free_shipping', 'gift']);
            $table->integer('value');
            $table->integer('probability')->default(1);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wheel_prizes');
    }
};
