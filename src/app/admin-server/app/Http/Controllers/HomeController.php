<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }

    public function top()
    { 
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }

}
