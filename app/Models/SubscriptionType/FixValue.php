<?php

namespace App\Models\SubscriptionType;

use Illuminate\Database\Eloquent\Model;

class FixValue extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_fix_value';

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->morphOne(Subscription::class, 'plan')->withDefault();
    }
}
