<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateFaqRequest;
use App\Http\Requests\CreateFaqRequest;
use Illuminate\View\View;
use App\Faq;
use DB;
use Session;

class FaqController extends Controller
{

    public function index()
    {
        $faq = Faq::orderBy('order', 'asc')->paginate(5);
        $menu_item = 'faq';
        return view('admin.faq.list')->with(['faq' => $faq, 'menu_item' => $menu_item]);
    }

    public function add()
    {
        return view('admin.faq.add')->with(['menu_item' => 'faq']);
    }

    public function create(CreateFaqRequest $request)
    {
        $title = $request['title'];
        $content = Faq::imageUpload($request['content']);
        $active = $request['active'];
        $order = $request['order'];
        try {
            Faq::insert(['title' => $title, 'content' => $content, 'active' => $active, 'order' => $order]);
            Session::flash('sucсess', 'Вопрос успешно добавлен');
            return redirect()->route('admin.faq');
        } catch (Exception $e) {
            Session::flash('erorr', 'Вопрос не был добавлен');
            return redirect()->route('admin.faq.add');
        }
    }

    public function edit($id)
    {
        $faq = Faq::where('id', $id)->first();
        return view('admin.faq.edit')->with(['id' => $faq->id,'title' => $faq->title,'content' => $faq->content,'active' => $faq->active,'order' => $faq->order]);
    }

    public function update(UpdateFaqRequest $request, $id)
    {
        $title = $request['title'];
        $content = Faq::imageUpload($request['content']);
        $active = $request->has('active') ? 1 : 0;
        $order = $request['order'] ?? 0;
        
        try {
            Faq::where('id', $id)
                ->update(['title' => $title, 'content' => $content,'active' => $active,'order' => $order]);
            Session::flash('sucсess', 'Вопрос успешно обновлен');
        } catch (Exception $e) {
            Session::flash('erorr', 'Ошибка при обновлении вопроса');
        }
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        try {
            Faq::where('id', '=', intval($id))->first()->delete();
            Session::flash('sucсess', 'Вопрос был удален.');
            return redirect()->route('admin.faq');
        } catch (Exception $e) {
            Session::flash('error', 'Что-то пошло не так.');
            return redirect()->back();
        }
    }

}
