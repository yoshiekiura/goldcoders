<?php

namespace App\Models\SubscriptionType;

use Illuminate\Database\Eloquent\Model;

class ProfitSharing extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_profit_sharing';

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->morphOne(Subscription::class, 'plan')->withDefault();
    }
}
