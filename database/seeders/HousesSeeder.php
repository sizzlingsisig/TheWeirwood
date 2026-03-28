<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HousesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $houses = [
            [1, 'House Stark',      75, 40, 15],
            [2, 'House Lannister',  30, 80, 35],
            [3, 'House Targaryen',  50, 70, 25],
            [4, 'House Baratheon',  55, 65, 20],
            [5, 'House Tyrell',     60, 50, 30],
            [6, 'House Martell',    65, 55, 18],
            [7, 'House Tully',      70, 45, 10],
            [8, 'House Arryn',      80, 35,  5],
            [9, 'House Greyjoy',    25, 75, 40],
        ];
        foreach ($houses as [$id, $name, $honor, $power, $debt]) {
            DB::table('houses')->updateOrInsert(['id' => $id], [
                'name'            => $name,
                'sigil_image_path'=> null,
                'starting_honor'  => $honor,
                'starting_power'  => $power,
                'starting_debt'   => $debt,
                'created_at'      => $now,
                'updated_at'      => $now,
                'deleted_at'      => null,
            ]);
        }
    }
}
