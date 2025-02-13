
<?php


use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Add All App Permissions
|--------------------------------------------------------------------------
*/


// Super Admins Permissions
$allPermissions = [
    'create-admin',
    'show-admin',
    'update-admin',
    'delete-admin',

    'show-publisher',
    'update-publisher',
    'delete-publisher',

    'show-customer',
    'update-customer',
    'delete-customer',

    'show-order',
    'update-order',
    'delete-order'

];

// Create Permissions
foreach ($allPermissions as $permission) {
    Permission::create(['name' => $permission, 'guard_name' => 'admin']);
};
