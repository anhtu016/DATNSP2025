<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->enum('order_status', ['pending', 'shipped', 'delivered', 'cancelled', 'cancel_requested', 'processing', 'delivering'])->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
};
