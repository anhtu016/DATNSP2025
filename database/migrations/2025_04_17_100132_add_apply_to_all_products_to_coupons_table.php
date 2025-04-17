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
        Schema::table('coupon', function (Blueprint $table) {
            $table->boolean('apply_to_all_products')->default(false)->after('end_date');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon', function (Blueprint $table) {
            //
        });
    }
};
