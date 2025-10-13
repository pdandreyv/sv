<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTable extends Migration
{
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('content');
            $table->integer('order');
            $table->integer('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faq');
    }
}


