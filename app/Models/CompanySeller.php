<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanySeller extends Pivot
{
    protected $table = 'company_seller';
    protected $fillable = ['company_id', 'seller_id', 'period_start', 'period_end', 'goal'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
