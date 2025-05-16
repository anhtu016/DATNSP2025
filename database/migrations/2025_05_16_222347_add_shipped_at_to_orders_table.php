<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('order', function (Blueprint $table) {
        $table->timestamp('shipped_at')->nullable()->after('delivering_at');
    });
}

public function down()
{
    Schema::table('order', function (Blueprint $table) {
        $table->dropColumn('shipped_at');
    });
}

};
