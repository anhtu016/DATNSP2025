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
            $table->dropForeign(['product_variant_attribute_value_id']);
            $table->dropColumn('product_variant_attribute_value_id');
        });
    }
    
    public function down()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variant_attribute_value_id');
            $table->foreign('product_variant_attribute_value_id')->references('id')->on('product_variant_attribute_values')->onDelete('cascade');
        });
    }
    
};
