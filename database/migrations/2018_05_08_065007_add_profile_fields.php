<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFields extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 50)->nullable()->default('');
            $table->string('middle_name', 50)->nullable()->default('');
            $table->string('last_name', 50)->nullable()->default('');
            $table->date('birth_date')->nullable()->default(null);
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('registration_address', 250)->nullable()->default('');
            $table->string('accomodation_address', 250)->nullable()->default('');
            $table->string('phone_number', 50)->nullable()->default('');
            $table->string('photo', 50)->nullable()->default('');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name','middle_name','last_name','birth_date','gender','registration_address','accomodation_address','phone_number','photo'
            ]);
        });
    }
}


