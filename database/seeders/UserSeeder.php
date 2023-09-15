<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'code' => Str::random(6),
            'firstname' => 'watcharin',
            'lastname' => 'khyokaj',
            'email' => 'nauthiz.rinz@gmail.com',
            'password' => Hash::make('191131'),
            'role_id' => '3ddd1f9b-689a-4fe9-8a76-56493794028d'
        ]);
    }
}
