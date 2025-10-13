<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('questionnaire_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('question_id');
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questionnaires')->onDelete('cascade');
            $table->unique(['user_id', 'question_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('questionnaire_answers');
    }
}


