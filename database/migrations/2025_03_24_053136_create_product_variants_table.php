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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('sku',150)->unique();
            $table->string('thumbnail');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('sell_price')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
