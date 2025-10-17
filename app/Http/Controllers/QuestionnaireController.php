<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questionnaire;
use App\QuestionnaireAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $menu_item = 'questionnaire';
        $questions = Questionnaire::orderBy('sort')->orderBy('id')->get();
        $answers = QuestionnaireAnswer::where('user_id', Auth::id())
            ->get()
            ->keyBy('question_id');
        return view('questionnaire.index', compact('questions', 'answers', 'menu_item'));
    }

    public function store(Request $request)
    {
        $answers = $request->input('answers', []);
        foreach ($answers as $questionId => $answerText) {
            QuestionnaireAnswer::updateOrCreate(
                ['user_id' => Auth::id(), 'question_id' => $questionId],
                ['answer' => $answerText]
            );
        }
        return redirect()->route('questionnaire.index');
    }
}


