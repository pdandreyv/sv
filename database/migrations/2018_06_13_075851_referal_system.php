<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReferalSystem extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alias')->nullable()->default('');
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alias','referrer_id']);
        });
    }
}


