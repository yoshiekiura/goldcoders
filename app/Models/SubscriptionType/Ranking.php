<?php

namespace App\Models\SubscriptionType;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    /**
     * @var string
     */
    public $table = 'subscription_ranking';

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->morphOne(Subscription::class, 'plan')->withDefault();
    }
}
