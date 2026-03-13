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
*/

// Marriage Specific Custom Routes
// (Keep these ABOVE the resource route to avoid 404/ID conflicts)
Route::get('/marriages/export-pdf', [MarriageRecordController::class, 'exportPDF'])->name('marriages.pdf');
Route::get('/marriages/{id}/pdf', [MarriageRecordController::class, 'generateSinglePdf'])->name('marriages.single_pdf');
Route::get('/marriages/{id}/generate-docx', [MarriageRecordController::class, 'generateDocx'])->name('marriages.docx');

// Standard Resource Routes
Route::resource('births', BirthRecordController::class);
Route::resource('marriages', MarriageRecordController::class);
Route::resource('deaths', DeathRecordController::class);

// Dashboard and Home
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', function () {
    return view('welcome');
});
