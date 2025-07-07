<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => env('MAIL_ADMIN_ADDRESS'),
            'password' => Hash::make('admin123'), // use a strong password
            'is_admin' => true,
        ]);
    }
}