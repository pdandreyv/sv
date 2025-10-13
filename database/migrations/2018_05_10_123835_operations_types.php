<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OperationsTypes extends Migration
{
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->nullable()->default('');
            $table->string('name', 50)->nullable()->default('');
            $table->timestamps();
        });

        Schema::table('users__replanish_balance_history', function (Blueprint $table) {
            $table->integer('operation_type_id')->unsigned();
            $table->foreign('operation_type_id')->references('id')->on('operations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('operations');
    }
}


