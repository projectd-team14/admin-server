<?php
 
namespace App\Http\Controllers\Download;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class CsvController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return view('layouts/app', compact('user'));
    }
 
    public function csvDownload(Request $request)
    {
        $data = $request->all();
 
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=GRAYCODE.csv");
        header("Content-Transfer-Encoding: binary");
 
        $csv = null;
        $csv = '"自転車ID","駐輪場","状態","登録日時","更新日時"' . "\n";
 
        foreach($data as $value) {
            $csv .= '"' . $value['bicycles_id'] . '","' . $value['spots_name'] . '","' . $value['bicycles_status'] . '","' . $value['created_at'] . '","' . $value['updated_at'] . '"' . "\n";
        }
 
        $csvValue = mb_convert_encoding($csv, "SJIS", "UTF-8");
 
        return $csvValue;
    }
}
 
