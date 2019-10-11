<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $casts = [
        'gateway_details' => 'array'
    ];


    protected $fillable = [
        'paymaster_id', 'member_id', 'date_enter', 'date_activated', 'activated', 'amount', 'gateway_id',
        'gateway_details'
    ];

    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

}
