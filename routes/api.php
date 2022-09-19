<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\linuxController;
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
Route::post('/decode-apl', [linuxController::class, 'index'])->name('linux');
Route::get('/initialize', [linuxController::class, 'initialize'])->name('initialize');
Route::post('/loadFiles', [linuxController::class, 'loadFiles'])->name('loadFiles');
Route::post('/loadZip', [linuxController::class, 'loadZip'])->name('loadZip');