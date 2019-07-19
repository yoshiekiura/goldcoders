<?php

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $admin = \Bouncer::role()->firstOrCreate([
            'name'  => 'admin',
            'title' => 'Administrator'
        ]);

        $paymaster = \Bouncer::role()->firstOrCreate([
            'name'  => 'paymaster',
            'title' => 'Paymaster'
        ]);
        $member = \Bouncer::role()->firstOrCreate([
            'name'  => 'member',
            'title' => 'Member'
        ]);

        $banned = \Bouncer::role()->firstOrCreate([
            'name'  => 'banned',
            'title' => 'Banned User'
        ]);

        \Bouncer::forbid($banned)->everything();

        $ban = \Bouncer::ability()->firstOrCreate([
            'name'  => 'ban-users',
            'title' => 'Ban users'
        ]);
        // This Will Activate Subscription
        $activate_subscription = \Bouncer::ability()->firstOrCreate([
            'name'  => 'activate-subscription',
            'title' => 'Activate Subscription'
        ]);
        // This Will Deactivate Subscription
        $deactivate_subscription = \Bouncer::ability()->firstOrCreate([
            'name'  => 'deactivate-subscription',
            'title' => 'Deactivate Subscription'
        ]);

        $delete_inactive_subscription = \Bouncer::ability()->firstOrCreate([
            'name'  => 'delete-inactive-subscription',
            'title' => 'Delete Inactive Subscription'
        ]);
        // This means Subscription is Already Activated
        $modify_locked_in_subscription = \Bouncer::ability()->firstOrCreate([
            'name'  => 'modify-locked-in-subscription',
            'title' => 'Modify Locked In Subscription'
        ]);

        $locked_in_subscription = \Bouncer::ability()->firstOrCreate([
            'name'  => 'locked-in-subscription',
            'title' => 'Locked In Subscription'
        ]);

        $view_referrals = \Bouncer::ability()->firstOrCreate([
            'name'  => 'view-referrals',
            'title' => 'View Referrals'
        ]);

        \Bouncer::allow('admin')->everything();

        \Bouncer::allow($admin)->to($ban);
        \Bouncer::allow($admin)->to($locked_in_subscription);

        \Bouncer::allow($paymaster)->to($activate_subscription, Subscription::class);
        \Bouncer::allow($paymaster)->to($deactivate_subscription, Subscription::class);
        \Bouncer::disallow($paymaster)->to($modify_locked_in_subscription, User::class);
        \Bouncer::disallow($paymaster)->to($locked_in_subscription, User::class);
        \Bouncer::allow($paymaster)->to($delete_inactive_subscription, Subscription::class);
        \Bouncer::disallow($paymaster)->to('delete', Subscription::class);
        \Bouncer::allow($paymaster)->toManage(Subscription::class);
        \Bouncer::allow($paymaster)->toOwn(Subscription::class);

        \Bouncer::allow($paymaster)->toManage(User::class);
        \Bouncer::allow($paymaster)->to($view_referrals, Subscription::class);

        // Make Cron Job to AutoDelete Inactive Subscription after 30 Days!

        \Bouncer::allow($member)->to('create', Subscription::class);
        \Bouncer::allow($member)->to('view', Subscription::class);
        \Bouncer::allow($member)->to('edit', Subscription::class);
        \Bouncer::allow($member)->to('update', Subscription::class);
        \Bouncer::disallow($member)->to('delete', Subscription::class);
        \Bouncer::allow($member)->toOwn(Subscription::class);
        \Bouncer::allow($member)->to($delete_inactive_subscription, Subscription::class);
        \Bouncer::disallow($member)->to($modify_locked_in_subscription, User::class);
        \Bouncer::disallow($member)->to($locked_in_subscription, User::class);

        \Bouncer::allow($paymaster)->to($view_referrals, Subscription::class);

    }
}
