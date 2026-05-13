<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function welcome()   { return view('welcome'); }
    public function work()      { return view('work'); }
    public function workDetail(){ return view('work-detail'); }
    public function studio()    { return view('studio'); }
    public function journal()   { return view('journal'); }
    public function services()  { return view('services'); }
}
