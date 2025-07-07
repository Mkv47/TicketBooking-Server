<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call your admin user seeder here:
        $this->call(AdminUserSeeder::class);
    }
}