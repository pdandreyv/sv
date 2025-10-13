<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderStatusEditConf extends Migration
{
    public function up()
    {
        Schema::table('orders__statuses', function (Blueprint $table) {
            $table->tinyInteger('not_editable')->default(0);
        });
        // Наполнение значений - через сиды/админку
    }

    public function down()
    {
        Schema::table('orders__statuses', function (Blueprint $table) {
            $table->dropColumn(['not_editable']);
        });
    }
}


