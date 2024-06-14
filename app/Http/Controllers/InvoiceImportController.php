<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceImport;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
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
        $filename = $request->hasFile('file') ? $request->file('file') : null;
        $companyId = $request->has('company_id') ? $request->company_id : null;

        $collectionExcel = Excel::toCollection(new InvoiceImport(), $filename);

        $collectionExcel->each(function ($row) use ($companyId) {
            //Create customer
            $customer = Customer::firstOrCreate([
                'code' => $row['customer_id'],
                'name' => $row['customer_name'],
                'branch_code' => $row['branch_id'],
                'branch_name' => $row['branch_name'],
                'group_code' => $row['customer_group_id'],
                'group_name' => $row['customer_group_name'],
            ]);

            //Create Seller
            $seller = Seller::firstOrCreate([
                'code' => $row['seller_id'],
                'name' => $row['seller_name'],
            ]);

            //Create Category
            $category = Category::firstOrCreate([
                'code' => $row['category_l1_id'],
                'name' => $row['category_l1_name'],
            ]);

            //Crate product
            $product = Product::firstOrCreate([
                'name' => $row['material_name'],
                'category_id' => $category->id,
                'uom' => $row['uom']
            ]);

            //Create Invoice
            $invoice = Invoice::firstOrCreate([
                'date' => $row['date'],
                'invoice_number' => $row['invoice_number'],
                'customer_id' => $customer->id,
                'seller_id' => $seller->id,
                'company_id' => $companyId,
                'total' => $row['total'],
                'payment_method_name' => $row['payment_method_name'],
            ]);

            //if invoice is created but not duplicated
            if ($invoice->wasRecentlyCreated) {
                $invoice->details()->create([
                    'quantity' => $row['quantity'],
                    'uom' => $row['uom'],
                    'product_id' => $product->id,
                    'unit_price' => $row['unit_price'],
                    'total' => $row['total'],
                ]);
            }
            
        });


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
