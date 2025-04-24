<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('11111111'),
            'admin' => true,
            'blocked' => false,
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => Hash::make('11111111'),
            'admin' => false,
            'blocked' => false,
        ]);

    }
}
