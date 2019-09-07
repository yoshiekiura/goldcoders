<?php

namespace App\Policies;

use App\Models\User;
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
        //
    }
    public function destroy(User $user){
        if($user->('manage_users')){
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
    public function edit(User $user)
    {
        if ($user->can('manage_users')) {
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
}
