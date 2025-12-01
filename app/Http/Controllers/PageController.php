<?php

namespace App\Http\Controllers;
use App\StaticPage;
use Illuminate\Http\Request;
use DB;
use Session;
use Route;
use Auth;

class PageController extends Controller

{

    public function viewPage(Request $request)
    {
        $alias = $request->segment(1);
        $page = StaticPage::where('alias',$alias)->firstOrFail();

        return view('page/view')->with(['page' => $page]);
    }
}
