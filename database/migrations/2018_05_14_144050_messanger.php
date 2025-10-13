<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messanger extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users__messages')) {
            Schema::create('users__messages', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('to_user_id')->nullable();
                $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('from_user_id')->nullable();
                $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->text('message_text');
                $table->boolean('is_readed')->nullable()->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('users__messages', function (Blueprint $table) {
                if (!Schema::hasColumn('users__messages', 'to_user_id')) {
                    $table->unsignedBigInteger('to_user_id')->nullable();
                }
                if (!Schema::hasColumn('users__messages', 'from_user_id')) {
                    $table->unsignedBigInteger('from_user_id')->nullable();
                }
                if (!Schema::hasColumn('users__messages', 'message_text')) {
                    $table->text('message_text');
                }
                if (!Schema::hasColumn('users__messages', 'is_readed')) {
                    $table->boolean('is_readed')->nullable()->default(0);
                }
                if (!Schema::hasColumn('users__messages', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn('users__messages', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users__messages');
    }
}


