<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderStatusEnumOnOrdersTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('pending', 'shipped', 'delivered', 'cancelled', 'cancel_requested') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('pending', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
}
