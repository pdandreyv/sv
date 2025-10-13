<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApplyOrder extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('applied')->default(0);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['applied']);
        });
    }
}


