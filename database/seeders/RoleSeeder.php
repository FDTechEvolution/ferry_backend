<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => Str::uuid(),
            'name' => 'Agent',
            'permission' => 'Agent'
        ]);

        DB::table('roles')->insert([
            'id' => Str::uuid(),
            'name' => 'User',
            'permission' => 'User'
        ]);
    }
}
