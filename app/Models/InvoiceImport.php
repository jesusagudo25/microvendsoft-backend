<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceImport extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'file_name', 'user_id', 'status'];
}
