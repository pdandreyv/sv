<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourcesUnitsForeign extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });
    }
}


