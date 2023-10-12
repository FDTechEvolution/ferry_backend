<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icon_name = [
            'Driving' => 'ico-driving.png', 
            'Fishing' => 'ico-fishing.png', 
            'Surfing' => 'ico-surfing.png', 
            'Swimming' => 'ico-swimming.png'
        ];

        foreach($icon_name as $key => $icon) {
            DB::table('icons')->insert([
                'id' => Str::uuid(),
                'name' => $key,
                'path' => '/icon/activity/'.$icon,
                'type' => 'activity'
            ]);
        }
    }
}
