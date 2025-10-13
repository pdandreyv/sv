<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    protected $table = 'questionnaire_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Questionnaire::class, 'question_id');
    }
}


