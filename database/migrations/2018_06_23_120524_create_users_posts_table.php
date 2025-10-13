<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPostsTable extends Migration
{
    public function up()
    {
        Schema::create('users_posts', function (Blueprint $table) {
            $table->increments('post_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('post_title');
            $table->text('post_content');
            $table->integer('stick_on_top')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_posts');
    }
}


