<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'username'          => $faker->unique()->userName,
        'email'             => $faker->unique()->safeEmail,
        'password'          => 'secret1234',
        'remember_token'    => str_random(10),
        'mobile_no'         => $faker->isbn10,
        'current_address'   => $faker->streetAddress,
        'permanent_address' => $faker->secondaryAddress,
        'fname'             => $faker->firstName,
        'mname'             => null, 
        'lname'             => $faker->lastName,
        'dob'               => Carbon::now()->subYears(random_int(18,25))->subMonths(random_int(1,12))->subDays(1,31),
        'suffix'            => $faker->suffix
    ];
});
