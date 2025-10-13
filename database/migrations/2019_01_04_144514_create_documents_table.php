<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('doc_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->nullable()->default('');
            $table->string('name', 50)->nullable()->default('');
            $table->timestamps();
        });
        Schema::create('doc_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('doc_category_id')->unsigned()->nullable();
        });
        Schema::create('doc_document', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_category_id')->unsigned()->nullable();
            $table->string('name', 50)->nullable()->default('');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doc_document');
        Schema::dropIfExists('doc_access');
        Schema::dropIfExists('doc_category');
    }
}


