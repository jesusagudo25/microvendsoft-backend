<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Seller;
use App\Models\SellerCommission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
        
        $sellersSpecial = [
            12,
            35,
            40,
            11,
            38
        ];

        //Get Store Logo

        $imgsCompany = [
            1 => public_path(Storage::url('img/logos/avicola.jpg')),
            2 => public_path(Storage::url('img/logos/deligrecia.png')),
            3 => public_path(Storage::url('img/logos/gruporamos.png')),
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
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('sum(total) as total_amount')
            ->first();

        //Obtener el total de ventas del mes actual y los anteriores pero del mismo año
        $salesMonths = [0,0,0,0,0,0,0,0,0,0,0,0];
        $currentMonth = date('m', strtotime($start_date));
        $currentYear = date('Y', strtotime($start_date));

        //Obtener el total de ventas del mes actual y los anteriores pero del mismo año
        for ($i = 1; $i <= $currentMonth; $i++) {

            $start = date('Y-m-d', strtotime($currentYear.'-'.$i.'-01'));
            $end = date('Y-m-t', strtotime($currentYear.'-'.$i.'-01'));

            $result = Invoice::whereBetween('date', [$start, $end])
                ->where('company_id', $company_id)
                ->selectRaw('sum(total) as total_amount')
                ->first();

            $salesMonths[$i-1] = $result->total_amount;
        }
        


        $invoicesTotalSpecial = Invoice::whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
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
        //corregir aqui que no parte de invoice, porque puede que el vendedor no venda nada.. y descuadra reporte
        $invoicesGroupedOneSeller = Invoice::join('sellers', 'invoices.seller_id', '=', 'sellers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
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

            $sellerComission = SellerCommission::updateOrCreate(
                [
                    'seller_id' => $invoice->seller_id,
                    'company_id' => $company_id,
                    'period_start' => $start_date,
                    'period_end' => $end_date
                ],
                [
                    'commission' => $invoice->commission,
                    'goal' => $invoice->goal,
                ]
            );

        });

        //Ordenar los vendedores por el porcentaje de cumplimiento de la cuota
        $invoicesGroupedOneSeller = $invoicesGroupedOneSeller->sortByDesc('goal_percentage');

        $invoicesGroupedOneSellerSpecial = Invoice::join('sellers', 'invoices.seller_id', '=', 'sellers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('invoices.seller_id, sellers.name, sum(total) as total_amount')
            ->groupBy('seller_id')
            ->get();

        //Tercer reporte: Obtener los clientes que más compraron en el rango de fechas
        $customersTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('customers.id, customers.name, sum(total) as total_amount')
            ->groupBy('customer_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        $customersTop10Special = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('customers.id, customers.name, sum(total) as total_amount')
            ->groupBy('customer_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Tercero y medio reporte: Obtener los branch_id (tipos de cloentes) que más compraron en el rango de fechas
        $customersGroupedTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
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
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('products.id, products.name, sum(invoice_details.total) as total_amount')
            ->groupBy('product_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        $productsTop10Special = Invoice::join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('products', 'invoice_details.product_id', '=', 'products.id')
            ->where('invoices.company_id', $company_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('products.id, products.name, sum(invoice_details.total) as total_amount')
            ->groupBy('product_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Quinto reporte: Notas de crédito en el rango de fechas (total < 0)
        $creditNotesMonth = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->where('total', '<', 0)
            ->selectRaw('invoices.invoice_number, customers.name, invoices.date, invoices.total')
            ->get();

        $creditNotesMonthSpecial = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
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
                'companyName',
                'invoicesTotalSpecial',
                'invoicesGroupedOneSellerSpecial',
                'customersTop10Special',
                'productsTop10Special',
                'creditNotesMonthSpecial',
                'salesMonths'
            )
        );

        return $pdf->stream('sales_report"'.preg_replace('/[^A-Za-z0-9]/', '', $companyName).'_'.strftime("%B", strtotime($start_date)).'.pdf');
    }

    public function reportSummary($end_date, $company_id)
    {
       $start_date = date('Y-m-01', strtotime('2024-01-01'));
        
        $sellersSpecial = [
            12,
            35,
            40,
            11,
            38
        ];

        //Get Store Logo

        $imgsCompany = [
            1 => public_path(Storage::url('img/logos/avicola.jpg')),
            2 => public_path(Storage::url('img/logos/deligrecia.png')),
            3 => public_path(Storage::url('img/logos/gruporamos.png')),
        ];

        $logo = $imgsCompany[$company_id];
        $companyName = Company::find($company_id)->name;
        //Se tiene el rango de fechas para el reporte

        //Primer reporte: Total de ventas por empresa en el rango de fechas, y se compara con la cuota establecida para cada empresa
            //Empresa sales
        $invoicesTotal = Invoice::where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('sum(total) as total_amount')
            ->first();

        $invoicesTotalSpecial = Invoice::where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('sum(total) as total_amount')
            ->first();
        
        //company_seller: sumar la cuota establecida total de ventas por empresa en el rango de fechas (company joined with company_seller)
        $CompanyGoal = Company::join('company_seller', 'companies.id', '=', 'company_seller.company_id')
            ->where('company_seller.company_id', $company_id)
            ->selectRaw('sum(company_seller.goal) as goal')
            ->first();

        //Segundo reporte: Total de ventas por empresa, agrupado por seller_id y sumando el total de venta, y se compara con la cuota establecida para el vendedor
        $invoicesGroupedOneSeller = Invoice::join('sellers', 'invoices.seller_id', '=', 'sellers.id')
            ->where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('invoices.seller_id, sellers.name, sum(total) as total_amount')
            ->groupBy('seller_id')
            ->get();

        $invoicesGroupedOneSeller->map(function ($invoice) use ( $end_date, $company_id) {
            $invoice->totalCommissions = SellerCommission::where('seller_id', $invoice->seller_id)
                ->where('company_id', $company_id)
                ->where('period_end', '<=', $end_date)
                ->sum('commission');
            $invoice->totalGoal = SellerCommission::where('seller_id', $invoice->seller_id)
                ->where('company_id', $company_id)
                ->where('period_end', '<=', $end_date)
                ->sum('goal');
                
            if ($invoice->totalGoal == 0) {
                $invoice->goal_percentage = 0;
                $invoice->goal_percentage_color = 'red';
            } else {
                $invoice->goal_percentage = ($invoice->total_amount / $invoice->totalGoal) * 100;
                $invoice->goal_percentage = round($invoice->goal_percentage) > 100 ? 100 : round($invoice->goal_percentage);
                $invoice->goal_percentage_color = $invoice->goal_percentage >= 100 ? 'green' : ($invoice->goal_percentage >= 90 ? 'yellow' : 'red');
            }

        });

        //Ordenar los vendedores por el porcentaje de cumplimiento de la cuota
        $invoicesGroupedOneSeller = $invoicesGroupedOneSeller->sortByDesc('goal_percentage');

        $invoicesGroupedOneSellerSpecial = Invoice::join('sellers', 'invoices.seller_id', '=', 'sellers.id')
            ->where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('invoices.seller_id, sellers.name, sum(total) as total_amount')
            ->groupBy('seller_id')
            ->get();

        //Tercer reporte: Obtener los clientes que más compraron en el rango de fechas
        $customersTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('customers.id, customers.name, sum(total) as total_amount')
            ->groupBy('customer_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        $customersTop10Special = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('customers.id, customers.name, sum(total) as total_amount')
            ->groupBy('customer_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Tercero y medio reporte: Obtener los branch_id (tipos de cloentes) que más compraron en el rango de fechas
        $customersGroupedTop10 = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->where('date','<=', $end_date)
            ->where('company_id', $company_id)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('customers.group_code, customers.group_name, sum(total) as total_amount')
            ->groupBy(['group_code', 'group_name'] )
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        //Cuarto reporte: Obtener los productos más vendidos en el rango de fechas
        $productsTop10 = Invoice::join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('products', 'invoice_details.product_id', '=', 'products.id')
            ->where('invoices.company_id', $company_id)
            ->where('date','<=', $end_date)
            ->whereNotIn('seller_id', $sellersSpecial)
            ->selectRaw('products.id, products.name, sum(invoice_details.total) as total_amount')
            ->groupBy('product_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        $productsTop10Special = Invoice::join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('products', 'invoice_details.product_id', '=', 'products.id')
            ->where('invoices.company_id', $company_id)
            ->where('date','<=', $end_date)
            ->whereIn('seller_id', $sellersSpecial)
            ->selectRaw('products.id, products.name, sum(invoice_details.total) as total_amount')
            ->groupBy('product_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();



        

        $pdf = PDF::loadView('reports.sales_summary', 
            compact(
                'start_date', 
                'end_date', 
                'invoicesTotal',
                'CompanyGoal',
                'invoicesGroupedOneSeller',
                'customersTop10',
                'customersGroupedTop10',
                'productsTop10',
                'logo',
                'companyName',
                'invoicesTotalSpecial',
                'invoicesGroupedOneSellerSpecial',
                'customersTop10Special',
                'productsTop10Special',
            )
        );

        return $pdf->stream('sales_report_sum"'.preg_replace('/[^A-Za-z0-9]/', '', $companyName).'_'.strftime("%B", strtotime($end_date)).'.pdf');
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
