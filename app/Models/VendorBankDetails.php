<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankDetails extends Model
{
    use HasFactory;

    protected $table = 'vendor_bank_details';

    protected $fillable = [
        'vendor_id',
        'acc_holder_name',
        'account_number',
        'bank_name',
        'ifsc_code',
        'branch',
    ];

}
