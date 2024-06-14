<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name',  'status'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
}
