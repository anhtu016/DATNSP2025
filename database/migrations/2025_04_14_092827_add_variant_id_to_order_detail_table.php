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
        Schema::table('order_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->after('product_id');
    
            
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
    
};
