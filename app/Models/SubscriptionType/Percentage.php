<?php

namespace App\Models\SubscriptionType;

use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_percentage';

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->morphOne(Subscription::class, 'plan')->withDefault();
    }
}
