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
            $table->timestamp('delivered_at')->nullable()->after('phone_number');
        });
    }

    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('delivered_at');
        });
    }
};
