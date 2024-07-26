<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\FeeSetting;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fee = ['2C2P', 'PATALL'];
        $name = ['2C2P', 'PAY@ALL'];

        foreach($fee as $index => $f) {
            FeeSetting::create([
                'name' => $name[$index],
                'type' => $f,
                'regular_pf' => '0',
                'child_pf' => '0',
                'infant_pf' => '0',
                'percent_pf' => '0',
                'regular_sc' => '0',
                'child_sc' => '0',
                'infant_sc' => '0',
                'percent_sc' => '0',
                'isuse_pf' => 'N',
                'isuse_sc' => 'N',
                'is_pf_perperson' => 'N',
                'is_sc_perperson' => 'N'
            ]);
        }
    }
}
