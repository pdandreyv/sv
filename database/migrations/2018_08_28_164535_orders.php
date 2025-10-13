<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    public function up()
    {
        Schema::create('users__shipping_adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->timestamps();
        });

        Schema::create('orders__statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->nullable()->default('');
            $table->string('name', 50)->nullable()->default('');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->float('sum', 12, 2)->nullable();
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('users__shipping_adresses')->onDelete('cascade');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('orders__statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('orders__items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products__products')->onDelete('cascade');
            $table->integer('quantity')->unsigned();
            $table->float('price', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders__items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orders__statuses');
        Schema::dropIfExists('users__shipping_adresses');
    }
}


