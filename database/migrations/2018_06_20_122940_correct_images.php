<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CorrectImages extends Migration
{
    public function up()
    {
        Schema::table('products__images', function (Blueprint $table) {
            $table->boolean('main')->default(0);
        });
    }

    public function down()
    {
        Schema::table('products__images', function (Blueprint $table) {
            $table->dropColumn(['main']);
        });
    }
}


