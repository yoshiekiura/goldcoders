<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Payment extends Model implements HasMedia
{

    use HasMediaTrait;

    protected $table = 'payments';
    protected $casts = [
        'payment_details' => 'array'
    ];

    protected $fillable = [
        'paymaster_id', 'member_id', 'date_paid', 'date_approved', 'approved', 'amount', 'gateway_id',
        'payment_details'
    ];

    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function scopeUnverifiedPayment($query)
    {
        $query->whereApproved(false);
    }
}
