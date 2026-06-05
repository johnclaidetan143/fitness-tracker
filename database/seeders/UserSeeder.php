<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => env('USER_EMAIL', 'user@example.com')],
            [
                'name' => env('USER_NAME', 'Demo User'),
                'password' => Hash::make(env('USER_PASSWORD', 'password')),
                'is_admin' => false,
            ]
        );

        $user->goals()->firstOrCreate([]);
    }
}
