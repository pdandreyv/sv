<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourcesAddUnits extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->integer('unit_id')->after('category_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('unit_id');
        });
    }
}


