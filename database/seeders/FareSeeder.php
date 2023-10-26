<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fare_name = [
            'Regular',
            'Child',
            'Infant',
            'Special Infant'
        ];

        foreach($fare_name as $fare) {
            DB::table('fares')->insert([
                'id' => Str::uuid(),
                'name' => $fare
            ]);
        }
    }
}
