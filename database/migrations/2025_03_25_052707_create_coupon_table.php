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
        Schema::create('coupon', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type',['percentage','fixed']);
            $table->unsignedBigInteger('value');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('min_order_value')->nullable();
            $table->unsignedBigInteger('max_discount_value')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
