<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderProductsFundDistribution extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('documents_types')) {
            Schema::create('documents_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 50);
                $table->string('name', 50);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('funds__funds')) {
            Schema::create('funds__funds', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 50)->default('');
                $table->string('name', 50)->default('');
                $table->tinyInteger('is_standart')->default(0);
                $table->double('balance', 8, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('funds__fund_distribution_algorithm')) {
            Schema::create('funds__fund_distribution_algorithm', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 50);
                $table->string('name', 50);
                $table->tinyInteger('is_standart')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('funds__fund_distribution_settings')) {
            Schema::create('funds__fund_distribution_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('algorithm_id')->unsigned();
                $table->foreign('algorithm_id')->references('id')->on('funds__fund_distribution_algorithm')->onDelete('cascade');
                $table->integer('fund_id')->unsigned();
                $table->foreign('fund_id')->references('id')->on('funds__funds')->onDelete('cascade');
                $table->double('percent');
                $table->tinyInteger('need_assess_pai')->default(0);
                $table->string('find_assess_pai_user_funck', 300)->default('');
                $table->integer('absent_case_fund_id')->unsigned()->nullable();
                $table->foreign('absent_case_fund_id')->references('id')->on('funds__funds')->onDelete('cascade');
                $table->timestamps();
            });
        }

        Schema::table('users__replanish_balance_history', function (Blueprint $table) {
            $table->integer('document_id')->unsigned()->nullable();
            $table->integer('document_type_id')->unsigned()->nullable();
            $table->foreign('document_type_id')->references('id')->on('documents_types')->onDelete('cascade');
            $table->integer('order_item_id')->unsigned()->nullable();
            $table->foreign('order_item_id')->references('id')->on('orders__items')->onDelete('cascade');
            $table->integer('fund_id')->unsigned()->nullable();
            $table->foreign('fund_id')->references('id')->on('funds__funds')->onDelete('cascade');
        });

        Schema::table('users__balance', function (Blueprint $table) {
            $table->double('work_pay')->default(0);
            $table->double('goods_pay')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users__replanish_balance_history', function (Blueprint $table) {
            $table->dropColumn(['document_id','document_type_id','order_item_id','fund_id']);
        });
        Schema::table('users__balance', function (Blueprint $table) {
            $table->dropColumn(['work_pay','goods_pay']);
        });
        Schema::dropIfExists('funds__fund_distribution_settings');
        Schema::dropIfExists('funds__fund_distribution_algorithm');
        Schema::dropIfExists('funds__funds');
        Schema::dropIfExists('documents_types');
    }
}


