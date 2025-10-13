<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddingViewsForInfoAccessInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('birth_date_view')->default(1);
            $table->tinyInteger('city_view')->default(1);
            $table->tinyInteger('phone_number_view')->default(1);
            $table->tinyInteger('email_view')->default(1);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birth_date_view','city_view','phone_number_view','email_view']);
        });
    }
}


