<?php

namespace Modules\Publisher\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Publisher\Models\Publisher;

class PublisherDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        $customer = Publisher::create([
            'name'              => 'Publisher',
            'email'             => 'publisher@publisher.com',
            'about'             => 'about publisher',
            'status'            => 1,
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);
    }
}
