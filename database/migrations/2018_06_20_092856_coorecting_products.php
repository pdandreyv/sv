<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoorectingProducts extends Migration
{
    public function up()
    {
        Schema::table('products__products', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('is_confirmed')->default(0);
        });
    }

    public function down()
    {
        Schema::table('products__products', function (Blueprint $table) {
            $table->dropColumn(['deleted_at','is_confirmed']);
        });
    }
}


