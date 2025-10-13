<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VerifiRegistration extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('token')->default('');
            $table->boolean('verified')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['token','verified']);
        });
    }
}


