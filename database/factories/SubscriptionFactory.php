<?php

use App\Models\Subscription;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Subscription::class, function (Faker $faker) {
    $plan = $faker->randomElement([
        'plan_1',
        'plan_2',
        'plan_3',
        'plan_4',
        'plan_5',
        'plan_6'
    ]);
    $rank = $faker->randomElement([
        '1ex',
        '1br',
        '1sl',
        '1gd',
        '1dm',
        '1lt'
    ]);

    $amount = config("plan.{$plan}.pay_in.{$rank}");
    // $amount = config('plan.plan_1.pay_in.1ex');
    return [
        'plan'           => $plan,
        'rank'           => $rank,
        'amount'         => $amount,
        'date_activated' => Carbon::now()->addDays(2),
        'date_paid'      => Carbon::now()
    ];
});
