<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRoles extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users__roles_names')) {
            Schema::create('users__roles_names', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        }

        if (!Schema::hasTable('users__roles')) {
            Schema::create('users__roles', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('role_id')->unsigned();
                $table->foreign('role_id')->references('id')->on('users__roles_names')->onDelete('cascade');
            });
        } else {
            Schema::table('users__roles', function (Blueprint $table) {
                if (!Schema::hasColumn('users__roles', 'user_id')) {
                    $table->unsignedBigInteger('user_id');
                }
                if (!Schema::hasColumn('users__roles', 'role_id')) {
                    $table->integer('role_id')->unsigned();
                }
                // Внешние ключи добавлять только при создании таблицы, чтобы не дублировать ограничения
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('users__roles')) {
            Schema::drop('users__roles');
        }
        if (Schema::hasTable('users__roles_names')) {
            Schema::drop('users__roles_names');
        }
    }
}


