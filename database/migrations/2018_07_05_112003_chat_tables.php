<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChatTables extends Migration
{
    public function up()
    {
        Schema::create('chat__chats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 600);
            $table->timestamps();
        });

        Schema::create('chat__members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chat_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chat__chats')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('chat__messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chat_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chat__chats')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('text');
            $table->timestamps();
        });

        Schema::create('chat__messages_reading', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->foreign('message_id')->references('id')->on('chat__messages')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat__messages_reading');
        Schema::dropIfExists('chat__messages');
        Schema::dropIfExists('chat__members');
        Schema::dropIfExists('chat__chats');
    }
}


