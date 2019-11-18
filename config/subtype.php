<?php

use App\Models\SubscriptionType\Ranking;
use App\Models\SubscriptionType\FixValue;
use App\Models\SubscriptionType\Percentage;
use App\Models\SubscriptionType\Compounding;
use App\Models\SubscriptionType\ProfitSharing;

return [
    'fix-value'      => FixValue::class,
    'percentage'     => Percentage::class,
    'compounding'    => Compounding::class,
    'ranking'        => Ranking::class,
    'profit-sharing' => ProfitSharing::class
];
