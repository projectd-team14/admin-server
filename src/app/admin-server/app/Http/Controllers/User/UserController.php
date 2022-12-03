<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;

class UserController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }

    public function createUser(Request $request)
    { 
        $data = $request->all();
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        if (is_null($data["create_spots"])) {
            return view('layouts/app', compact('user', 'spot'));
        }
        
        dd($data);
    }
}
