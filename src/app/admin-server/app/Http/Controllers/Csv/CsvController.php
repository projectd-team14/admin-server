<?php

namespace App\Http\Controllers\Csv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }

    public function csvCreate()
    { 
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }
}
