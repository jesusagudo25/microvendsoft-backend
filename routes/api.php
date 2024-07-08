<?php

use App\Http\Controllers\InvoiceImportController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Aurhentication
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Test
Route::get('/test', function () {
    return 'Hello World';
});

// Importer invoices

Route::controller(InvoiceImportController::class)->group(function () {
    Route::post('/import-invoices', 'store');
});

// Invoices
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index');
    Route::get('/invoices-report/{start_date}/{end_date}/{company_id}', 'report');
    Route::get('/invoices-report-summary/{end_date}/{company_id}', 'reportSummary');
    Route::get('/invoices/{id}', 'show');
    Route::post('/invoices', 'store');
    Route::put('/invoices/{id}', 'update');
    Route::delete('/invoices/{id}', 'destroy');
});