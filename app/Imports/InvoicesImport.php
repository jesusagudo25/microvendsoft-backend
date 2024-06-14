<?php

namespace App\Imports;

use App\Models\InvoiceDetailImport;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoicesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new InvoiceDetailImport([
            'date' => $row[0],
            'invoice_number' => $row[1],
            'customer_id' => $row[2],
            'customer_name' => $row[3],
            'branch_id' => $row[4],
            'branch_name' => $row[5],
            'customer_group_id' => $row[6],
            'customer_group_name' => $row[7],
            'seller_id' => $row[8],
            'seller_name' => $row[9],
            
            'quantity' => $row[10],
            'uom' => $row[11],
            'material_name' => $row[13],
            'category_l1_id' => $row[14],
            'category_l1_name' => $row[15],
            'total' => $row[20],
            'unit_price' => $row[21],
            'payment_method_name' => $row[23],
        ]);
    }
}
