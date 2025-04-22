<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->timestamp('processing_at')->nullable()->after('order_status');
            $table->timestamp('delivering_at')->nullable()->after('processing_at');
        });
    }
    
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('processing_at');
            $table->dropColumn('delivering_at');
        });
    }
    
};
