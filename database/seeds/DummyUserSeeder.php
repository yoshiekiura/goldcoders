<?php

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        // test paymaster
        $paymaster = User::create([
            'email'             => 'paymaster@goldcoders.club',
            'password'          => config('admin.password'),
            'username'          => 'paymaster1234',
            'active'            => true,
            'remember_token'    => Str::random(10),
            'mobile_no'         => $faker->isbn10,
            'current_address'   => $faker->streetAddress,
            'permanent_address' => $faker->secondaryAddress,
            'fname'             => 'paymaster',
            'mname'             => null,
            'lname'             => 'number1',
            'dob'               => Carbon::now()->subYears(random_int(18, 25))->subMonths(random_int(1, 12))->subDays(1, 31),
            'suffix'            => null
        ]);
        $paymaster->assignRole('admin', 'paymaster');
        $subscriptions = factory(Subscription::class, 10)->create();
        $paymaster->subscriptions()->saveMany($subscriptions);
        $paymaster->save();
        // test member
        $member = User::create([
            'paymaster_id'      => User::first()->id,
            'email'             => 'member@goldcoders.club',
            'password'          => config('admin.password'),
            'username'          => 'member1234',
            'active'            => false,
            'remember_token'    => Str::random(10),
            'mobile_no'         => $faker->isbn10,
            'current_address'   => $faker->streetAddress,
            'permanent_address' => $faker->secondaryAddress,
            'fname'             => 'member',
            'mname'             => null,
            'lname'             => 'number1',
            'dob'               => Carbon::now()->subYears(random_int(18, 25))->subMonths(random_int(1, 12))->subDays(1, 31),
            'suffix'            => null
        ]);
        $member->assignRole('member');
        $subscriptions = factory(Subscription::class, 10)->create();
        $member->subscriptions()->saveMany($subscriptions);
        $member->save();

        /* test referrals */
        factory(User::class, 5)->create()->each(function ($user) use ($member, $paymaster) {
            $user->paymaster_id = $paymaster->id;
            $user->sp_id        = $member->id;
            $user->active       = false;
            $user->assignRole('member');
            $subscriptions = factory(Subscription::class, 10)->create();
            $user->subscriptions()->saveMany($subscriptions);
            $user->save();
        });
    }
}
