<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'uuid' => Str::uuid(),
                'name' => 'Test User',
                'email' => 'test@example.com',
                'mobile' => '9876543210',
                'password' => bcrypt('password'),
            ]);
        }
    }
}