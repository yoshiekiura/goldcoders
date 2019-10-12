<?php

namespace App\Traits\User;

use App\Models\User;
use App\Models\Ctrader;
use App\Models\Subscription;

trait Relationships
{
    /**
     * Referrals Relationship
     *
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'sp_id');
    }

    /**
     * Sponsor Relationship
     *
     */
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sp_id');
    }

    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }

    public function underlings()
    {
        return $this->hasMany(User::class, 'paymaster_id');
    }

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function ctraderToken()
    {
        return $this->hasOne(Ctrader::class, 'user_id');
    }
}
