<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBank extends Model
{
    use HasFactory;

    protected $fillable = [
       'vendor_id','account_no','bank_name','ifsc_code','branch'
    ];
}
