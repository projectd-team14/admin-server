<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Bicycle;

class DownloadController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }

    public function createList(Request $request)
    { 
        $user = \Auth::user();
        $data = $request->all();
        $spot = Spot::get(['spots_id', 'spots_name']);

        $spotList = [];
        $bicycleList = [];

        if ($data['spots_id'] === "0") {
            if ($data['spots_status'] === "3") {
                $spotList = Spot::get();
            } else {
                $spotList = Spot::where('spots_status', $data['spots_status'])->get();
            }
        } else {
            $spotList = Spot::where('spots_id', $data['spots_id'])->where('spots_status', $data['spots_status'])->get();   
        }

        if ($data['spots_category'] === "0") {
            for ($i = 0; $i < count($spotList); $i++) {
                $query = Bicycle::where('spots_id',$spotList[$i]['spots_id'])->whereBetween('created_at', [$data['created_at'], $data['updated_at']])->get();

                for ($i2 = 0; $i2 < count($query); $i2++) {
                    $data = [
                        'bicycles_id' => $query[$i2]['bicycles_id'],
                        'spots_name' => $spotList[$i]['spots_name'],
                        'bicycles_status' => $query[$i2]['bicycles_status'],
                        'created_at' => $query[$i2]['created_at'],
                        'updated_at' => $query[$i2]['updated_at']
                    ];
                    array_push($bicycleList, $data);
                }
            }
        } else {
            for ($i = 0; $i < count($spotList); $i++) {
                $query = Bicycle::where('spots_id',$spotList[$i]['spots_id'])->where('bicycles_status', '違反')->whereBetween('created_at', [$data['created_at'], $data['updated_at']])->get();
                for ($i2 = 0; $i2 < count($query); $i2++) {
                    $data = [
                        'bicycles_id' => $query[$i2]['bicycles_id'],
                        'spots_name' => $spotList[$i]['spots_name'],
                        'bicycles_status' => $query[$i2]['bicycles_status'],
                        'created_at' => $query[$i2]['created_at'],
                        'updated_at' => $query[$i2]['updated_at']
                    ];
                    array_push($bicycleList, $data);
                }
            }   
        }

        return view('layouts/app', compact('user', 'spot', 'bicycleList'));
    }
}
