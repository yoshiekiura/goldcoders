<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //we can inject here an auth user instance
    }

    /**
     * @param User $user
     */
    public function approvePayment(User $user)
    {
        if ($user->can('approve_payment') && Auth::user()->id === $user->paymaster_id || $user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function editProfile(User $user)
    {
        if ($user->can('edit_profile')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function sendmail(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function view(User $user)
    {
        if ($user->can('manage_users')) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function view_referrals(User $user)
    {
        $auth = auth()->user();

        if ($auth->can('manage_users')) {
            return true;
        }

        if ($auth->id === $user->sp_id) {
            return true;
        }
    }
}
