<?php

use App\Http\Controllers\InvoiceImportController;
use App\Models\Invoice;
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