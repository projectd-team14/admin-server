<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;

class ChartController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }

    public function createChart(Request $request)
    { 
        $data = $request->all();
        $spotData = [];
        $chartData = '';

        if (!($data['create_spots'] === "0")) {
            if ($data['spots_chart_type'] === '0') {
                $spotData = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'spots_name', 'spots_violations']);
                $chartData = $spotData[0]['spots_violations'];
            } else if ($data['spots_chart_type'] === '1') {
                $spotData = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'spots_name', 'spots_count_day1']);
                $chartData = $spotData[0]['spots_count_day1'];
            } else if ($data['spots_chart_type'] === '2') {
                $spotData = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'spots_name', 'spots_count_week1']);
                $chartData = $spotData[0]['spots_count_week1'];
            } else if ($data['spots_chart_type'] === '3') {
                $spotData = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'spots_name', 'spots_count_month1']);
                $chartData = $spotData[0]['spots_count_month1'];
            } else {
                $spotData = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'spots_name', 'spots_count_month3']);
                $chartData = $spotData[0]['spots_count_month3'];
            }
        }

        $chartDataList = explode(",", $chartData);
        $labelsData = [];

        if ($data['spots_chart_type'] === "1") {
            for ($i = 0; $i < count($chartDataList); $i++) {
                $objDateTime = date('Y-m-d H:i:', strtotime("-$i hour"));
                array_push($labelsData, $objDateTime);
            }            
        } else {
            for ($i = 0; $i < count($chartDataList); $i++) {
                $objDateTime = date('Y-m-d', strtotime("-$i day"));
                array_push($labelsData, $objDateTime);
            }
        }

        $labelsData = array_reverse($labelsData);

        $dataAll = [
            'spots_id' => $spotData[0]['spots_id'],
            'spots_name' => $spotData[0]['spots_name'],
            'spots_data' => $chartDataList,
            'labels' => $labelsData,
        ];

        return $dataAll;
    }

    public function chartSpot()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }
}
