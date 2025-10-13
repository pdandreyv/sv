<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailTemplates extends Migration
{
    public function up()
    {
        Schema::create('mail__templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('used_vars')->nullable()->default('{{:user_fullname}}');
            $table->tinyInteger('is_standart')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mail__templates');
    }
}


