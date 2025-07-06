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
            'email' => 'mohammedad.work@gmail.com',
            'password' => Hash::make('admin123'), // use a strong password
            'is_admin' => true,
        ]);
    }
}