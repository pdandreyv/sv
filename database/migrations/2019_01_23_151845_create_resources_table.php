<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('products__categories')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resources');
    }
}


