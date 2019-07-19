<?php

use App\Models\User;
use App\Models\Subscription;
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
        /* Paymaster */

        factory(User::class, 1)->create()->each(function ($user) {
            \Bouncer::assign('paymaster')->to($user);
            $subscriptions = factory(Subscription::class, 10)->create();
            $user->subscriptions()->saveMany($subscriptions);
            $user->save();
        });
        /* Member */
        factory(User::class, 1)->create()->each(function ($user) {
            \Bouncer::assign('member')->to($user);
            $subscriptions = factory(Subscription::class, 10)->create();
            $user->subscriptions()->saveMany($subscriptions);
            $user->save();
        });
    }
}
