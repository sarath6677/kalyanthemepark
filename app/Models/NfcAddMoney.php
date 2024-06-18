<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfcAddMoney extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'cashback_amount'];

}
