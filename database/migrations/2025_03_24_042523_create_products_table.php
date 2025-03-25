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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('slug',200)->unique();
            $table->string('sku',150)->unique();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('sell_price')->default(0);
            $table->text('short_description');
            $table->text('description');
            $table->string('thumbnail');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedBigInteger('brand_id');
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
