<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Faq;

class FaqController extends Controller
{

    public function index()
    {
        $faq = Faq::all()->sortBy('faq_sort_order');
        return view('faq.list')->with(['faq' => $faq]);
    }

}
