<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\StaticPage;
use Illuminate\Http\Request;
use App\Faq;
use DB;
use Session;

class PageController extends Controller
{

    public function index()
    {
        $pages = StaticPage::orderBy('id', 'asc')->paginate(25);
        $menu_item = 'page';

        return view('admin.page.list')->with(['pages' => $pages, 'menu_item' => $menu_item]);
    }

    public function add()
    {
        return view('admin.page.add')->with([
            'menu_item' => 'page',
            'h1' => '',
            'alias' => '',
            'body' => '',
        ]);
    }

    public function create(PageRequest $request)
    {
        $body = Faq::imageUpload($request['body']);
        try {
            StaticPage::insert([
                'h1' => $request['h1'],
                'body' => $body,
                'display' => $request['display'],
                'alias' => $request['alias'],
                'title' => $request['title'],
                'descr' => $request['descr'],
            ]);
            Session::flash('sucсess', 'Страница создана');
            return redirect()->route('admin.page');
        } catch (Exception $e) {
            Session::flash('erorr', 'page не был добавлен');
            return redirect()->route('admin.page.add');
        }
    }

    public function edit($id)
    {
        $page = StaticPage::where('id', $id)->first();
        return view('admin.page.edit')->with([
            'id' => $page->id,
            'h1' => $page->h1,
            'body' => $page->body,
            'display' => $page->display,
            'alias' => $page->alias,
            'title' => $page->title,
            'descr' => $page->descr,
        ]);
    }

    public function update(Request $request, $page_id)
    {
        $body = Faq::imageUpload($request['body']);
        //$active = $request->has('active') ? 1 : 0;

        try {
            StaticPage::where('id', $page_id)->update([
                'h1' => $request['h1'],
                'body' => $body,
                'display' => $request['display'],
                'alias' => $request['alias'],
                'title' => $request['title'],
                'descr' => $request['descr'],
            ]);

            Session::flash('success', 'Страница обновлена');
        } catch (Exception $e) {
            Session::flash('error', 'Ошибка при обновлении страницы');
        }
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        try {
            StaticPage::where('id', '=', intval($id))->first()->delete();
            Session::flash('sucсess', 'Страница была удалена.');
            return redirect()->route('admin.page');
        } catch (Exception $e) {
            Session::flash('error', 'Что-то пошло не так.');
            return redirect()->back();
        }
    }

}
