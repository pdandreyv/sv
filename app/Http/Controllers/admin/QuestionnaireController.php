<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Questionnaire;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $menu_item = 'questionnaire';
        $questions = Questionnaire::orderBy('id', 'desc')->paginate(20);
        return view('admin.questionnaire.index', compact('questions', 'menu_item'));
    }

    public function create()
    {
        $menu_item = 'questionnaire';
        return view('admin.questionnaire.create', compact('menu_item'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required|string|max:500',
            'type' => 'required|in:short,long',
            'description' => 'nullable|string',
        ]);

        Questionnaire::create([
            'question' => $request->input('question'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.questionnaire.index');
    }

    public function edit($id)
    {
        $menu_item = 'questionnaire';
        $question = Questionnaire::findOrFail($id);
        return view('admin.questionnaire.edit', compact('question', 'menu_item'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'required|string|max:500',
            'type' => 'required|in:short,long',
            'description' => 'nullable|string',
        ]);

        $question = Questionnaire::findOrFail($id);
        $question->update([
            'question' => $request->input('question'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.questionnaire.index');
    }

    public function delete($id)
    {
        $question = Questionnaire::findOrFail($id);
        $question->delete();
        return redirect()->route('admin.questionnaire.index');
    }
}


