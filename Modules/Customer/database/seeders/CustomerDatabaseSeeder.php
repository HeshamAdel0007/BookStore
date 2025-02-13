<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $customer = Customer::create([
            'name' => 'Customer',
            'email' => 'customer@admin.com',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);
    }
}
