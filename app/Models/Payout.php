<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Payout extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $casts = [
        'payout_details' => 'array'
    ];

    protected $fillable = [
        'paymaster_id', 'member_id', 'date_payout', 'date_approved', 'approved', 'amount', 'gateway_id',
        'payout_details'
    ];

    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function scopeVerifiedPayouts($query)
    {
        $query->whereApproved(true);
    }
    public function scopeUnverifiedPayouts($query)
    {
        $query->whereApproved(false);
    }
}
