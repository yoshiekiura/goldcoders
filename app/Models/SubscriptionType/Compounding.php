<?php

namespace App\Models\SubscriptionType;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class Compounding extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_compounding';

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->morphOne(Subscription::class, 'plan')->withDefault();
    }
}
