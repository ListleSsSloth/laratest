<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Demo1Controller extends Controller
{
    public function get()
    {
        return view('pages.demo.demopage1')->withTitle('Demopage1');
        //return redirect()->back()->with('message','redirected');
    }
}
