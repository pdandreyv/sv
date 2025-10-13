<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('users', 'email')) {
                    $table->string('email')->unique();
                }
                if (!Schema::hasColumn('users', 'password')) {
                    $table->string('password');
                }
                if (!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }
                if (!Schema::hasColumn('users', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}


