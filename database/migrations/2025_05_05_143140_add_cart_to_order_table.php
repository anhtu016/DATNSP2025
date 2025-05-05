<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// database/migrations/xxxx_xx_xx_xxxxxx_add_cart_to_orders_table.php
public function up()
{
    Schema::table('order', function (Blueprint $table) {
        $table->text('cart')->nullable(); // Cột này sẽ lưu giỏ hàng dưới dạng JSON
    });
}

public function down()
{
    Schema::table('order', function (Blueprint $table) {
        $table->dropColumn('cart');
    });
}

};
