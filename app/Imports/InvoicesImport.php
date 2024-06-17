<?php

namespace App\Imports;

use App\Models\InvoiceDetailImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InvoicesImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
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
            'material_name' => $row[12],
            'category_l1_id' => $row[13],
            'category_l1_name' => $row[14],
            'total' => $row[15],
            'unit_price' => $row[16],
            'payment_method_name' => $row[17],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 10000;
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
