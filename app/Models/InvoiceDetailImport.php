<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetailImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoice_number',
        'customer_id',
        'customer_name',
        'branch_id',
        'branch_name',
        'customer_group_id',
        'customer_group_name',
        'seller_id',
        'seller_name',
        'quantity',
        'uom',
        'material_name',
        'category_l1_id',
        'category_l1_name',
        'total',
        'unit_price',
        'payment_method_name',
    ];
}
