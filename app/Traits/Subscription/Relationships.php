<?php

namespace App\Traits\Subscription;

use App\Models\User;

trait Relationships
{
    /**
     * @return mixed
     */
    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }

    /**
     * @return mixed
     */
    public function plan()
    {
        return $this->morphTo();
    }

    /**
     * [user Eloquent Relationship].
     *
     * @return [Collection] [User Belongs To Relationship]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
