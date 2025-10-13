<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BalanceTables extends Migration
{
    public function up()
    {
        Schema::create('users__replanish_balance_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('sum');
            $table->boolean('paid')->default(0);
            $table->timestamps();
        });

        Schema::create('users__balance', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('sum');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users__balance');
        Schema::dropIfExists('users__replanish_balance_history');
    }
}


