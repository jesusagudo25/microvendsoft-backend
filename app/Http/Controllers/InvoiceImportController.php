<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Imports\InvoicesImport;
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

        $collectionExcel = Excel::toCollection(new InvoicesImport(), $filename);

        return response()->json(['message' => 'Invoices imported successfully']);

        try {
            collect($collectionExcel[0])->each(function ($row, $key) use ($companyId) {
                //Create customer
                

                $customer = Customer::firstOrCreate([
                    'code' => $row[2],
                    'name' => $row[3],
                    'branch_code' => $row[4],
                    'branch_name' => $row[5],
                    'group_code' => $row[6],
                    'group_name' => $row[7],
                ]);
    
                //Create Seller
                $seller = Seller::firstOrCreate([
                    'code' => $row[8],
                    'name' => $row[9],
                ]);
    
                //Create Category
                $category = Category::firstOrCreate([
                    'code' => $row[13],
                    'name' => $row[14],
                ]);
    
                //Crate product
                $product = Product::firstOrCreate([
                    'name' => $row[12],
                    'category_id' => $category->id,
                    'uom' => $row[11],
                ]);
    
                //Create Invoice
                //date: 02.01.2024 to 2024-01-02
                $invoice = Invoice::firstOrCreate([
                    'date' => date('Y-m-d', strtotime(str_replace('.', '-', $row[0]))),
                    'invoice_number' => $row[1],
                    'customer_id' => $customer->id,
                    'seller_id' => $seller->id,
                    'company_id' => $companyId,
                    'total' => $row[15],
                    'payment_method_name' => $row[17],
                ]);
    
                //Create Invoice Detail
                $invoice->details()->create([
                    'quantity' => $row[10],
                    'product_id' => $product->id,
                    'unit_price' => $row[16],
                    'total' => $row[15],
                ]);

                
            }); 
    
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json(['message' => $message], 500);
        }

        return response()->json(['message' => 'Invoices imported successfully']);


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
