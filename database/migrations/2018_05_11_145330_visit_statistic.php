<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VisitStatistic extends Migration
{
    public function up()
    {
        Schema::create('users__visit_statistic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ip', 50);
            $table->string('url', 300);
            $table->dateTime('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users__visit_statistic');
    }
}


