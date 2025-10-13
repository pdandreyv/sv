<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderStatuses extends Migration
{
    public function up()
    {
        Schema::table('orders__statuses', function (Blueprint $table) {
            $table->tinyInteger('is_standart')->default(0);
        });
        // значения по умолчанию добавляются сидером/через админку
    }

    public function down()
    {
        Schema::table('orders__statuses', function (Blueprint $table) {
            $table->dropColumn(['is_standart']);
        });
    }
}


