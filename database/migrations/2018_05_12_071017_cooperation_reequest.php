<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CooperationReequest extends Migration
{
    public function up()
    {
        Schema::create('users__users_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_type_id')->unsigned()->nullable();
            $table->foreign('user_type_id')->references('id')->on('users__users_types')->onDelete('cascade');
            $table->string('passport_series')->nullable()->default('');
            $table->string('passport_number')->nullable()->default('');
            $table->string('passport_give')->nullable()->default('');
            $table->date('passport_give_date')->nullable()->default(null);
            $table->string('identification_code')->nullable()->default('');
        });

        Schema::create('users__scans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type', ['passport1', 'passport2', 'passport3', 'identification_code'])->nullable();
            $table->string('file_name')->nullable()->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users__scans');
        Schema::dropIfExists('users__users_types');
    }
}


