<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNetwork extends Migration
{
    public function up()
    {
        Schema::create('network', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('ups1')->nullable();
            $table->foreign('ups1')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('ups2')->nullable();
            $table->foreign('ups2')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('ups3')->nullable();
            $table->foreign('ups3')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('network');
    }
}


