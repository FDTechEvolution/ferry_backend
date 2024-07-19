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
            'Bus (1)' => 'ico-bus-1.png',
            'Car ferry (1)' => 'ico-car-ferry-1.png',
            'Catamaran (1)' => 'ico-catamaran-1.png',
            'Cruise ship (1)' => 'ico-cruise-ship-1.png',
            'Ferry (1)' => 'ico-ferry-1.png',
            'High Speed Ferry (1)' => 'ico-high-speed-ferry-1.png',
            'Long tail boat (1)' => 'ico-long-tail-boat-1.png',
            'Speed boat (1)' => 'ico-speed-boat-1.png',
            'Van (1)' => 'ico-van-1.png'
        ];

        foreach($icon_name as $key => $icon) {
            DB::table('icons')->insert([
                'id' => Str::uuid(),
                'name' => $key,
                'path' => '/icon/route/'.$icon,
                'type' => 'route'
            ]);
        }
    }
}
