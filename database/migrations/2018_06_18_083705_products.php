<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    public function up()
    {
        Schema::create('products__products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->float('price', 8, 2);
            $table->float('cooperative_price', 8, 2);
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('products__categories')->onDelete('set null');
            $table->integer('quantity')->nullable();
            $table->float('weight', 10, 3)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_service');
        });

        Schema::create('products__images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('old_name');
            $table->string('new_name');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products__products')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('products__categories', function (Blueprint $table) {
            $table->boolean('for_service');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products__images');
        Schema::dropIfExists('products__products');
    }
}


