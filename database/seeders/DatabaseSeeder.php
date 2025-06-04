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
            'password' => Hash::make('111'),
            'admin' => true,
            'blocked' => false,
            'resources' => '[*]',
            'verbs' => '[*]'
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => Hash::make('111'),
            'admin' => false,
            'blocked' => false,
            'resources' => '[*]',
            'verbs' => '[*]'
        ]);

        DB::table('clusters')->insert([
            'name' => 'DefaultCluster',
            'user_id' => 1,
            'endpoint' => 'http://172.29.176.1:8001', 
            'auth_type' => 'P',
            'timeout' => 5,
        ]);

    }
}
