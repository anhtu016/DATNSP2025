<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// Migration to remove permissions from users table
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('permissions');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->json('permissions')->nullable();
    });
}

};
