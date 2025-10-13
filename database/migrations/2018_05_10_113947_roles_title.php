<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesTitle extends Migration
{
    public function up()
    {
        Schema::table('users__roles_names', function (Blueprint $table) {
            $table->string('title', 50)->nullable()->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users__roles_names', function (Blueprint $table) {
            $table->dropColumn(['title']);
        });
    }
}


