<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        $owner = Admin::create([
            'name'              => 'Owner',
            'email'             => 'hesham@adel.com',
            'phone'             => +201275372663,
            'status'            => 1,
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);
        $admin = Admin::create([
            'name'              => 'Admin',
            'email'             => 'admin@admin.com',
            'status'            => 1,
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);
    }
}
