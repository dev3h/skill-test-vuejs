<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Admin",
                'email' => "admin@yopmail.com",
                'email_verified_at' => now(),
                'password' => bcrypt('a12345678X'),
            ],
            [
                'name' => "Apple",
                'email' => "apple@yopmail.com",
                'email_verified_at' => now(),
                'password' => bcrypt('a12345678X'),
            ]
        ];
        foreach ($data as $user) {
            User::create($user);
        }
    }
}
