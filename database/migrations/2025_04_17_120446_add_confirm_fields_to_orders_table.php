<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable(); // Khi đơn hàng được giao
            $table->boolean('is_confirmed')->default(false); // Người dùng đã xác nhận hoàn tất hay chưa
            $table->timestamp('confirmed_at')->nullable(); // Khi người dùng xác nhận
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
};
