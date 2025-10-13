<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCity extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->default('');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['city']);
        });
    }
}


