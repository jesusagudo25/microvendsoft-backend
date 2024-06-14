<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'branch_code', 'branch_name', 'group_code', 'group_name', 'status'];
}
