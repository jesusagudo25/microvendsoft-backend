<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Imports\InvoicesImport;
use App\Jobs\ProcessLargeExcel;
use App\Models\InvoiceDetailImport;
use App\Models\InvoiceImport;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = $request->has('company_id') ? $request->company_id : null;
        $filename = $request->file('file');

        //set unlimited memory limit
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        if ($filename) {
            $filename = $filename->store('invoices', 'public');
            $invoiceImport = InvoiceImport::create([
                'user_id' => 1,
                'file_name' => $filename,
                'company_id' => $companyId,
            ]);

            ProcessLargeExcel::dispatch(storage_path('app/public/' . $filename), $companyId);

            return response()->json(['message' => 'Invoices imported successfully'], 201);
        }else{
            return response()->json(['message' => 'No file uploaded'], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceImport $invoiceImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceImport $invoiceImport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceImport $invoiceImport)
    {
        //
    }
}
