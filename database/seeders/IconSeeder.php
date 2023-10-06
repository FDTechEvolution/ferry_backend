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
        $icon_name = ['ico-boat.png', 'ico-ferry.png', 'ico-speed-boat.png', 'ico-van.png'];

        foreach($icon_name as $icon) {
            DB::table('icons')->insert([
                'id' => Str::uuid(),
                'name' => $icon,
                'path' => '/icon/route/',
                'type' => 'route'
            ]);
        }
    }
}
