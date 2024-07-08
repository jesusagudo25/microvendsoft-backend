<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerCommission extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'company_id', 'commission', 'period_start', 'period_end', 'goal'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
