<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('resources_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resource_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->float('volume')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('products__categories');
            $table->foreign('resource_id')->references('id')->on('resources');
            $table->unique(['user_id', 'resource_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('resources_users');
    }
}


