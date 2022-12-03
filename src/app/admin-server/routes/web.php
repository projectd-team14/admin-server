<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Csv\CsvController;
use App\Http\Controllers\Download\DownloadController;
use App\Http\Controllers\Chart\ChartController;
use App\Http\Controllers\Camera\CameraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['firewall'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // ホーム
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // ダッシュボード
    Route::get('/top', [HomeController::class, 'top'])->name('top');
    // 検索・ダウンロード
    Route::get('/download', [DownloadController::class, 'index'])->name('download');
    Route::post('/create_list', [DownloadController::class, 'createList'])->name('download');
    // 分析データ
    Route::get('/chart', [ChartController::class, 'index'])->name('chart');
    Route::get('/chart_spot', [ChartController::class, 'chartSpot'])->name('chart_spot');
    // カメラ
    Route::get('/camera', [cameraController::class, 'index'])->name('camera');
    Route::post('/create_camera', [CameraController::class, 'createCamera'])->name('camera');
    // Route::post('/create_chart', [ChartController::class, 'createChart'])->name('chart');
    // Route::post('/delete_chart', [ChartController::class, 'deleteChart'])->name('chart');
});
Auth::routes();

