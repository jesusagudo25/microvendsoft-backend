<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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


class ProcessLargeExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    protected $companyId;

    /**
     * Create a new job instance.
     */
    public function __construct($filename, $companyId)
    {
        $this->filename = $filename;
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //set unlimited memory limit
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $collectionExcel = Excel::toCollection(new InvoicesImport(), $this->filename);
        $companyId = $this->companyId;

        try {
            collect($collectionExcel[0])->each(function ($row, $key) use ($companyId) {
                //Create customer
                

                $customer = Customer::firstOrCreate([
                    'code' => $row[2],
                    'name' => $row[3],
                    'branch_code' => $row[4] == null ? 'Default' : $row[4],
                    'branch_name' => $row[5] == null ? 'Default' : $row[5],
                    'group_code' => $row[6] == null ? 'Default' : $row[6],
                    'group_name' => $row[7] == null ? 'Default' : $row[7],
                ]);

                //if seller is empty, create a default seller or use default seller: code 1, name 'Default'
                if($row[8] == null){
                    $row[8] = 1;
                    $row[9] = 'Default';
                }
    
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

                //search invoice number 
                $invoicesExists = Invoice::where('invoice_number', $row[1])->first();
                
                //if invoice exists, not create, skip. Only add invoice detail
                if($invoicesExists){
                    $invoicesExists->invoiceDetails()->create([
                        'quantity' => $row[10],
                        'product_id' => $product->id,
                        'unit_price' => $row[16],
                        'total' => $row[15],
                    ]);
                }
                else{
                    $invoice = Invoice::firstOrCreate([
                        'date' => date('Y-m-d', strtotime(str_replace('.', '-', $row[0]))),
                        'invoice_number' => $row[1],
                        'customer_id' => $customer->id,
                        'user_id' => 1, //User 'Admin
                        'seller_id' => $seller->id,
                        'company_id' => $companyId,
                        'total' => $row[15] == null ? 0 : $row[15],
                        'payment_method' => $row[17],
                    ]);
        
                    //Create Invoice Detail
                    $invoice->invoiceDetails()->create([
                        'quantity' => $row[10],
                        'product_id' => $product->id,
                        'unit_price' => $row[16] == null ? 0 : $row[16],
                        'total' => $row[15] == null ? 0 : $row[15],
                    ]);
                }

            }); 
    
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json(['message' => $message], 500);
        }
    }
}
