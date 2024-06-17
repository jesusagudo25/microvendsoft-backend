<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Seller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function report($start_date, $end_date, $company_id)
    {
        ini_set('memory_limit', '-1');
        

        $imgsCompany = [
            1 => 'https://gathanasiadisr.com/wp-content/uploads/2016/06/Avicola-Grecia.jpg',
            2 => 'https://gathanasiadisr.com/wp-content/uploads/2016/06/Deligrecia.jpg',
            3 => 'https://gathanasiadisr.com/wp-content/uploads/2017/06/Arroz-Veraguas.jpg',
        ];

        $logo = $imgsCompany[$company_id];
        $companyName = Company::find($company_id)->name;
        //Se tiene el rango de fechas para el reporte

        //Son tres empresas que venden productos (id:1, id:2, id:3)

        //company_id = 1

        //Primer reporte: Total de ventas por empresa en el rango de fechas, y se compara con la cuota establecida para cada empresa
            //Empresa sales
        $invoicesTotalMonth = Invoice::whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->selectRaw('sum(total) as total_amount')
            ->first();
        
            //company_seller: sumar la cuota establecida total de ventas por empresa en el rango de fechas (company joined with company_seller)
        $CompanyGoalMonth = Company::join('company_seller', 'companies.id', '=', 'company_seller.company_id')
            ->where('company_seller.period_start', '=', $start_date)
            ->where('company_seller.period_end', '=', $end_date)
            ->where('company_seller.company_id', $company_id)
            ->selectRaw('sum(company_seller.goal) as goal')
            ->first();

        //Segundo reporte: Total de ventas por empresa, agrupado por seller_id y sumando el total de venta, y se compara con la cuota establecida para el vendedor
            //De acuerdoa al porcentaje de cumplimiento de la cuota, se debe mostrar un color en el reporte, verde si se cumplió, amarillo si se acercó al 100% y rojo si no se cumplió
            //Este porcentaje nos ayudará a identificar si el vendedor ganara una comisión por cumplimiento de cuota
        
        $invoicesGroupedOneSeller = Invoice::join('sellers', 'invoices.seller_id', '=', 'sellers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->selectRaw('invoices.seller_id, sellers.name, sum(total) as total_amount')
            ->groupBy('seller_id')
            ->get();

        $invoicesGroupedOneSeller->map(function ($invoice) use ($start_date, $end_date, $company_id) {
            $seller = Seller::find($invoice->seller_id);
            $companySeller = Company::join('company_seller', 'companies.id', '=', 'company_seller.company_id')
                ->where('company_seller.company_id', $company_id)
                ->where('seller_id', $invoice->seller_id)
                ->where('period_start', $start_date)
                ->where('period_end', $end_date)
                ->select('company_seller.goal')
                ->first();
                

            //if seller_id is 26, then the seller is not in the company_seller table
            if ($companySeller) {
                $invoice->goal = $companySeller->goal;

                $invoice->goal_percentage = ($invoice->total_amount / $companySeller->goal) * 100;
                $invoice->goal_percentage = round($invoice->goal_percentage) > 100 ? 100 : round($invoice->goal_percentage);

                $invoice->goal_percentage_color = $invoice->goal_percentage >= 100 ? 'green' : ($invoice->goal_percentage >= 90 ? 'yellow' : 'red');
                $invoice->commission = number_format($seller->searchCommission($seller->name, $start_date, $end_date, $invoice->goal_percentage, $company_id), 2);
            } else {
                $invoice->goal = 0;
                $invoice->percentage = 0;
                $invoice->goal_percentage_color = 'red';
                $invoice->commission = 0;
            }

        });

        //Tercer reporte: Obtener los clientes que más compraron en el rango de fechas
        $customersTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->selectRaw('customers.id, customers.name, sum(total) as total_amount')
            ->groupBy('customer_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Tercero y medio reporte: Obtener los branch_id (tipos de cloentes) que más compraron en el rango de fechas
        $customersGroupedTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->selectRaw('customers.group_code, customers.group_name, sum(total) as total_amount')
            ->groupBy(['group_code', 'group_name'] )
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Cuarto reporte: Obtener los productos más vendidos en el rango de fechas
        $productsTop10 = Invoice::join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('products', 'invoice_details.product_id', '=', 'products.id')
            ->where('invoices.company_id', $company_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->selectRaw('products.id, products.name, sum(invoice_details.total) as total_amount')
            ->groupBy('product_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Quinto reporte: Notas de crédito en el rango de fechas (total < 0)
        $creditNotesMonth = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->where('total', '<', 0)
            ->selectRaw('invoices.invoice_number, customers.name, invoices.date, invoices.total')
            ->get();

        $pdf = PDF::loadView('reports.sales', 
            compact(
                'start_date', 
                'end_date', 
                'invoicesTotalMonth',
                'CompanyGoalMonth',
                'invoicesGroupedOneSeller',
                'customersTop10',
                'customersGroupedTop10',
                'productsTop10',
                'creditNotesMonth',
                'logo',
                'companyName'
            )
        );

        return $pdf->stream('sales_report.pdf');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
