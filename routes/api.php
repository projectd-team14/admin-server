<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Spot\SpotController;
use App\Http\Controllers\Download\CsvController;
use App\Http\Controllers\Chart\ChartController;
 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ホワイトリストを設けてアクセスできるIPを制御する。
Route::middleware(['firewall'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/spot_admin_get/{id}', [SpotController::class, 'spotAdminGet']);
    Route::post('/csv_download', [CsvController::class, 'csvDownload']); 
    Route::post('/create_chart', [ChartController::class, 'createChart'])->name('chart');
});