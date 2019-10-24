<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'edit_profile']);
        Permission::create(['name' => 'activate_link']);
        Permission::create(['name' => 'deactivate_link']);
        Permission::create(['name' => 'edit_link']);
        Permission::create(['name' => 'upload_avatar']);
        Permission::create(['name' => 'add_media']);
        Permission::create(['name' => 'edit_media']);
        Permission::create(['name' => 'delete_media']);
        Permission::create(['name' => 'manage_site']);
        Permission::create(['name' => 'manage_media']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_roles']);
        Permission::create(['name' => 'manage_permissions']);

        Permission::create(['name' => 'approve_payment']);

        Permission::create(['name' => 'access_all']);
        Permission::create(['name' => 'add_access_token']);

        Permission::create(['name' => 'view_payments']);
        Permission::create(['name' => 'create_payment']);
        Permission::create(['name' => 'edit_payment']);
        Permission::create(['name' => 'delete_payment']);

        Permission::create(['name' => 'view_gateway']);
        Permission::create(['name' => 'create_gateway']);
        Permission::create(['name' => 'edit_gateway']);
        Permission::create(['name' => 'delete_gateway']);

        Permission::create(['name' => 'view_payouts']);
        Permission::create(['name' => 'create_payout']);
        Permission::create(['name' => 'edit_payout']);
        Permission::create(['name' => 'delete_payout']);

        Permission::create(['name' => 'view_contract_manager']);
        Permission::create(['name' => 'view_admin_contract_manager']);
        Permission::create(['name' => 'view_user_contract_manager']);

        Permission::create(['name' => 'view_contract_manager_user']);
        Permission::create(['name' => 'create_contract_manager_user']);
        Permission::create(['name' => 'edit_contract_manager_user']);
        Permission::create(['name' => 'delete_contract_manager_user']);

        Permission::create(['name' => 'view_contract_manager_admin']);
        Permission::create(['name' => 'create_contract_manager_admin']);
        Permission::create(['name' => 'edit_contract_manager_admin']);
        Permission::create(['name' => 'delete_contract_manager_admin']);

        Permission::create(['name' => 'view_referrals']);
        Permission::create(['name' => 'view_ctrader_account']);
        Permission::create(['name' => 'view_profile']);
        Permission::create(['name' => 'view_kyc']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('edit_profile');
        $role->givePermissionTo('edit_link');
        $role->givePermissionTo('activate_link');
        $role->givePermissionTo('upload_avatar');
        $role->givePermissionTo('deactivate_link');
        $role->givePermissionTo('add_media');
        $role->givePermissionTo('edit_media');
        $role->givePermissionTo('delete_media');
        $role->givePermissionTo('manage_site');
        $role->givePermissionTo('manage_media');
        $role->givePermissionTo('manage_users');
        $role->givePermissionTo('manage_roles');
        $role->givePermissionTo('manage_permissions');
        $role->givePermissionTo('add_access_token');
        $role->givePermissionTo('access_all');

        $role->givePermissionTo('view_payments');
        $role->givePermissionTo('create_payment');
        $role->givePermissionTo('edit_payment');
        $role->givePermissionTo('delete_payment');

        $role->givePermissionTo('view_gateway');
        $role->givePermissionTo('create_gateway');
        $role->givePermissionTo('edit_gateway');
        $role->givePermissionTo('delete_gateway');

        $role->givePermissionTo('view_payouts');
        $role->givePermissionTo('create_payout');
        $role->givePermissionTo('edit_payout');
        $role->givePermissionTo('delete_payout');

        $role->givePermissionTo('view_contract_manager');
        $role->givePermissionTo('view_admin_contract_manager');
        $role->givePermissionTo('view_user_contract_manager');

        $role->givePermissionTo('view_contract_manager_user');
        $role->givePermissionTo('create_contract_manager_user');
        $role->givePermissionTo('edit_contract_manager_user');
        $role->givePermissionTo('delete_contract_manager_user');

        $role->givePermissionTo('view_contract_manager_admin');
        $role->givePermissionTo('create_contract_manager_admin');
        $role->givePermissionTo('edit_contract_manager_admin');
        $role->givePermissionTo('delete_contract_manager_admin');

        $role->givePermissionTo('view_referrals');
        $role->givePermissionTo('view_ctrader_account');
        $role->givePermissionTo('view_profile');
        $role->givePermissionTo('view_kyc');
        






        $role = Role::create(['name' => 'paymaster']);
        $role->givePermissionTo('edit_profile');
        $role->givePermissionTo('approve_payment');
        $role->givePermissionTo('edit_link');
        $role->givePermissionTo('activate_link');
        $role->givePermissionTo('deactivate_link');
        $role->givePermissionTo('upload_avatar');
        $role->givePermissionTo('add_media');
        $role->givePermissionTo('edit_media');
        $role->givePermissionTo('delete_media');
        $role->givePermissionTo('add_access_token');
        $role->givePermissionTo('view_payments');
        $role->givePermissionTo('create_payment');
        $role->givePermissionTo('edit_payment');
        $role->givePermissionTo('delete_payment');

        $role->givePermissionTo('view_gateway');
        $role->givePermissionTo('create_gateway');
        $role->givePermissionTo('edit_gateway');
        $role->givePermissionTo('delete_gateway');

        $role->givePermissionTo('view_payouts');
        $role->givePermissionTo('create_payout');
        $role->givePermissionTo('edit_payout');
        $role->givePermissionTo('delete_payout');

        $role->givePermissionTo('view_contract_manager');
        $role->givePermissionTo('view_admin_contract_manager');
        $role->givePermissionTo('view_user_contract_manager');

        $role->givePermissionTo('view_contract_manager_user');
        $role->givePermissionTo('create_contract_manager_user');
        $role->givePermissionTo('edit_contract_manager_user');
        $role->givePermissionTo('delete_contract_manager_user');

        $role->givePermissionTo('view_contract_manager_admin');
        $role->givePermissionTo('create_contract_manager_admin');
        $role->givePermissionTo('edit_contract_manager_admin');
        $role->givePermissionTo('delete_contract_manager_admin');

        $role->givePermissionTo('view_referrals');
        $role->givePermissionTo('view_ctrader_account');
        $role->givePermissionTo('view_profile');
        $role->givePermissionTo('view_kyc');


        $role = Role::create(['name' => 'member']);
        $role->givePermissionTo('edit_profile');
        $role->givePermissionTo('edit_link');
        $role->givePermissionTo('activate_link');
        $role->givePermissionTo('upload_avatar');
        $role->givePermissionTo('view_payments');
        $role->givePermissionTo('create_payment');
        $role->givePermissionTo('edit_payment');
        $role->givePermissionTo('delete_payment');

        $role->givePermissionTo('view_payouts');
        $role->givePermissionTo('create_payout');
        $role->givePermissionTo('edit_payout');
        $role->givePermissionTo('delete_payout');

        $role->givePermissionTo('view_contract_manager');
        $role->givePermissionTo('view_user_contract_manager');

        $role->givePermissionTo('view_contract_manager_user');
        $role->givePermissionTo('create_contract_manager_user');
        $role->givePermissionTo('edit_contract_manager_user');
        $role->givePermissionTo('delete_contract_manager_user');

        $role->givePermissionTo('view_profile');
        $role->givePermissionTo('view_kyc');


    }
}
