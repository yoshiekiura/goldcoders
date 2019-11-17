<?php

use App\Models\CommissionType\Ranking;
use App\Models\CommissionType\FixValue;
use App\Models\CommissionType\Percentage;
use App\Models\CommissionType\Compounding;
use App\Models\CommissionType\ProfitSharing;

return [
    'fix_value'      => FixValue::class,
    'percentage'     => Percentage::class,
    'compounding'    => Compounding::class,
    'ranking'        => Ranking::class,
    'profit_sharing' => ProfitSharing::class
];
