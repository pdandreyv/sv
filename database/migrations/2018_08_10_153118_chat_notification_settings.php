<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChatNotificationSettings extends Migration
{
    public function up()
    {
        Schema::create('chat__messages_notification_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('chat_type', ['private', 'group']);
            $table->enum('frequency', ['never', 'every', 'daily', 'weekly', 'mounthly']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat__messages_notification_settings');
    }
}


