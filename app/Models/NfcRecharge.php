<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfcRecharge extends Model
{
    use HasFactory;

    protected $fillable = ['card_id', 'user_id', 'amount'];

    /**
     * Get the user associated with the NfcRecharge
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
