<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;

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
        $spot = Spot::where('spots_count_month1', '<>', 'None')->where('spots_violations', '<>', 'None')->get(['spots_id', 'spots_name', 'spots_url', 'spots_latitude', 'spots_longitude', 'spots_address', 'spots_count_month1', 'spots_violations']);

        $spotsCountMonth = [];
        $spotsCountViolations = [];

        for ($i = 0; $i < count($spot); $i++) {
            $monsList = explode(',', $spot[$i]['spots_count_month1']);
            $violationsList = explode(',', $spot[$i]['spots_violations']);

            array_push($spotsCountMonth, $monsList);
            array_push($spotsCountViolations, $violationsList);                
        }
        
        $countMonthAll = [];
        $countViolationsAll = [];

        for ($i = 0; $i < 30; $i++) {
            $countMonth = 0;

            for ($i2 = 0; $i2 < count($spotsCountMonth); $i2++) {
                $countMonth = $countMonth + (int)$spotsCountMonth[$i2][$i];
            }

            array_push($countMonthAll, $countMonth);
        }

        for ($i = 0; $i < 30; $i++) {
            $countViolations = 0;

            for ($i2 = 0; $i2 < count($spotsCountViolations); $i2++) {
                $countViolations = $countViolations + (int)$spotsCountViolations[$i2][$i];
            }
            
            array_push($countViolationsAll, $countViolations);
        }

        $labels = [];

        for ($i = 0; $i < count($countViolationsAll); $i++) {
            $objDateTime = date('Y-m-d', strtotime("-$i day"));
            array_push($labels, $objDateTime);
        }

        $labels = array_reverse($labels);

        $data = [
            'labels' => $labels,
            'month_list' => $countMonthAll,
            'violation_list' => $countViolationsAll
        ];

        return view('layouts/app', compact('user', 'spot', 'data'));
    }

    public function top()
    { 
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }

}
