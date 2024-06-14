<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name',  'status'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }
}
