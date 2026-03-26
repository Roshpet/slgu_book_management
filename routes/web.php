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

// --- Birth Specific Custom Routes ---
Route::get('/births/export-pdf', [BirthRecordController::class, 'exportPDF'])->name('births.pdf');
Route::get('/births/{id}/pdf', [BirthRecordController::class, 'generateSinglePdf'])->name('births.single_pdf');
Route::get('/births/{id}/generate-docx', [BirthRecordController::class, 'generateDocx'])->name('births.docx');

// --- Marriage Specific Custom Routes ---
Route::get('/marriages/export-pdf', [MarriageRecordController::class, 'exportPDF'])->name('marriages.pdf');
Route::get('/marriages/{id}/pdf', [MarriageRecordController::class, 'generateSinglePdf'])->name('marriages.single_pdf');
Route::get('/marriages/{id}/generate-docx', [MarriageRecordController::class, 'generateDocx'])->name('marriages.docx');

// --- Death Specific Custom Routes ---
Route::get('/deaths/export-pdf', [DeathRecordController::class, 'exportPDF'])->name('deaths.pdf');
Route::get('/deaths/{id}/pdf', [DeathRecordController::class, 'generateSinglePdf'])->name('deaths.single_pdf');
Route::get('/deaths/{id}/generate-docx', [DeathRecordController::class, 'generateDocx'])->name('deaths.docx');

// --- Standard Resource Routes ---
Route::resource('births', BirthRecordController::class);
Route::resource('marriages', MarriageRecordController::class);
Route::resource('deaths', DeathRecordController::class);

// --- Dashboard and Home ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', function () {
    return view('welcome');
});
