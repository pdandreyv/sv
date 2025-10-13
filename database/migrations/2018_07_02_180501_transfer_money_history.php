<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransferMoneyHistory extends Migration
{
    public function up()
    {
        Schema::table('users__replanish_balance_history', function (Blueprint $table) {
            $table->unsignedBigInteger('user_to_id')->nullable();
            $table->foreign('user_to_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users__replanish_balance_history', function (Blueprint $table) {
            $table->dropColumn(['user_to_id']);
        });
    }
}


