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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->string('shipping_address');
            $table->dateTime('order_date');
            $table->unsignedBigInteger('shipping_method_id');
            $table->unsignedBigInteger('payment_methods_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('order_status',['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
