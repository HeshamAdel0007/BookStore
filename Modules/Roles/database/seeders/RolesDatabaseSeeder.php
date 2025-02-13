<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;
use Spatie\Permission\Models\Role;
use Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Modules\Publisher\Models\Publisher;
use Spatie\Permission\PermissionRegistrar;

class RolesDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        require __DIR__ . '/AllPermissions.php';

        $roles = [
            'super-admin' => 'admin',
            'admin'       => 'admin',
            'publisher'   => 'publisher',
            'customer'    => 'customer',
        ];

        foreach ($roles as $role => $value) {
            Role::create(['name' => $role, 'guard_name' => $value]);
        };


        // Giv Owner Role SuperAdmin & All-Permissions
        $admin = Admin::where('id', 1)->first();
        $admin->assignRole('super-admin');
        $admin->givePermissionTo($allPermissions);

        // Giv  Admin Role Admin
        $admin = Admin::where('id', 2)->first();
        $admin->assignRole('admin');

        // Giv User Publisher Role Publisher
        $publisher = Publisher::where('id', 1)->first();
        $publisher->assignRole('publisher');

        // Giv User Customer Role Customer
        $customer = Customer::where('id', 1)->first();
        $customer->assignRole('customer');
    }
}
