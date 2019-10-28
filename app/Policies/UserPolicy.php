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
     * @param User $User
     */
    public function add_access_token(User $user)
    {
        if ($user->can('add_access_token')) {
            return true;
        }
    }

    public function approval_payment_approved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_payment_approved')) {
            return true;
        }
    }

    public function approval_payment_disapproved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_payment_disapproved')) {
            return true;
        }
    }

    public function approval_payout_approved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_payout_approved')) {
            return true;
        }
    }

    public function approval_payout_disapproved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_payout_disapproved')) {
            return true;
        }
    }

    public function approval_userfile_approved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_userfile_approved')) {
            return true;
        }
    }

    public function approval_userfile_disapproved()
    {
        $auth = auth()->user();

        if ($auth->can('view_approval_userfile_disapproved')) {
            return true;
        }
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

    public function create_contract_manager_admin()
    {
        $auth = auth()->user();

        if ($auth->can('create_contract_manager_admin')) {
            return true;
        }
    }

    public function create_contract_manager_user()
    {
        $auth = auth()->user();

        if ($auth->can('create_contract_manager_user')) {
            return true;
        }
    }

    public function create_gateway()
    {
        $auth = auth()->user();

        if ($auth->can('create_gateway')) {
            return true;
        }
    }

    public function create_payment()
    {
        $auth = auth()->user();

        if ($auth->can('create_payment')) {
            return true;
        }
    }

    public function create_payout()
    {
        $auth = auth()->user();

        if ($auth->can('create_payout')) {
            return true;
        }
    }

    public function delete_contract_manager_admin()
    {
        $auth = auth()->user();

        if ($auth->can('delete_contract_manager_admin')) {
            return true;
        }
    }

    public function delete_contract_manager_user()
    {
        $auth = auth()->user();

        if ($auth->can('delete_contract_manager_user')) {
            return true;
        }
    }

    public function delete_gateway()
    {
        $auth = auth()->user();

        if ($auth->can('delete_gateway')) {
            return true;
        }
    }

    public function delete_payment()
    {
        $auth = auth()->user();

        if ($auth->can('delete_payment')) {
            return true;
        }
    }

    public function delete_payout()
    {
        $auth = auth()->user();

        if ($auth->can('delete_payout')) {
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
     * @param AdminFileManager $contract_manager_admin
     */
    public function edit_own_contract_manager_admin(AdminFileManager $contract_manager_admin)
    {
        $auth = auth()->user();

        if ($auth->can('edit_contract_manager_admin') && $contract_manager_admin->member_id === $auth->id) {
            return true;
        }
    }

    /**
     * @param UserFileManager $contract_manager_user
     */
    public function edit_own_contract_manager_user(UserFileManager $contract_manager_user)
    {
        $auth = auth()->user();

        if ($auth->can('edit_contract_manager_user') && $contract_manager_user->member_id === $auth->id) {
            return true;
        }
    }

    /**
     * @param Gateway $gateway
     */
    public function edit_own_gateway(Gateway $gateway)
    {
        $auth = auth()->user();

        if ($auth->can('edit_gateway') && $gateway->member_id === $auth->id) {
            return true;
        }
    }

    /**
     * @param Payment $payment
     */
    public function edit_own_payment(Payment $payment)
    {
        $auth = auth()->user();

        if ($auth->can('edit_payment') && $payment->member_id === $auth->id) {
            return true;
        }
    }

    /**
     * @param Payout $payout
     */
    public function edit_own_payout(Payout $payout)
    {
        $auth = auth()->user();

        if ($auth->can('edit_payout') && $payout->member_id === $auth->id) {
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

    public function view_contract_manager_admin()
    {
        $auth = auth()->user();

        if ($auth->can('view_contract_manager_admin')) {
            return true;
        }
    }

    public function view_contract_manager_user()
    {
        $auth = auth()->user();

        if ($auth->can('view_contract_manager_user')) {
            return true;
        }
    }

    public function view_gateway()
    {
        $auth = auth()->user();

        if ($auth->can('view_gateway')) {
            return true;
        }
    }

    public function view_payments()
    {
        $auth = auth()->user();

        if ($auth->can('view_payments')) {
            return true;
        }
    }

    public function view_payouts()
    {
        $auth = auth()->user();

        if ($auth->can('view_payouts')) {
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
