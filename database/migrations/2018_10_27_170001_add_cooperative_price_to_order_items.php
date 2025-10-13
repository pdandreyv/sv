<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCooperativePriceToOrderItems extends Migration
{
    public function up()
    {
        Schema::table('orders__items', function (Blueprint $table) {
            $table->float('cooperative_price', 8, 2);
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->float('cooperative_price', 8, 2);
        });
    }

    public function down()
    {
        Schema::table('orders__items', function (Blueprint $table) {
            $table->dropColumn(['cooperative_price']);
        });
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn(['cooperative_price']);
        });
    }
}


