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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_attribute_value_id');
            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_variant_attribute_value_id')->references('variant_id')->on('product_variant_attribute_values');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
