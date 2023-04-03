<?php

namespace App\Http\Controllers\Spot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;

class SpotController extends Controller
{
    public function spotAdminGet()
    {
        $spot = Spot::get();

        return $spot;
    }
}
