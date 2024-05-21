<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'mobile_numer',
        'address',
        'card_number',
        'card_amount',
    ];

}
