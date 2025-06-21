<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['nama' => 'admin',
            'no_telp' => '081234567891',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
            ],
            ['nama' => 'user-1',
            'no_telp' => '081234567892',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            ],
        ]);
    }
}