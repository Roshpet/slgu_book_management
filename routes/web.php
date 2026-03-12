<?php

use App\Http\Controllers\BirthRecordController;
use App\Http\Controllers\MarriageRecordController;
use App\Http\Controllers\DeathRecordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::resource('births', BirthRecordController::class);
Route::resource('marriages', MarriageRecordController::class);
Route::resource('deaths', DeathRecordController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', function () {
    return view('welcome');
});
