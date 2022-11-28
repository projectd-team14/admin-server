<?php

namespace App\Http\Controllers\Camera;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Camera;

class CameraController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }

    public function createCamera(Request $request)
    { 
        $data = $request->all();
        $user = \Auth::user();
        $camera = Camera::where('spots_id', $data['spots_id'])->get(['cameras_id', 'cameras_name', 'cameras_url']);
        $spot = Spot::get(['spots_id', 'spots_name']);
        $spotName = Spot::where('spots_id', $data['spots_id'])->get(['spots_name']);

        return view('layouts/app', compact('user', 'camera', 'spot', 'spotName'));
    }
}
