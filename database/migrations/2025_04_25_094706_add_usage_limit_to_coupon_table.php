<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->integer('usage_limit')->nullable()->default(null);
        });
    }
    
    public function down()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->dropColumn('usage_limit');
        });
    }
    
};
