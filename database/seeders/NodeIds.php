<?php

namespace Database\Seeders;

class NodeIds
{
    public static array $map = [
        // Merged Ch I+II (3 nodes) → Ch III (5 nodes) = TRUNK_01-08
        'TRUNK_01' => 1,  'TRUNK_02' => 2,  'TRUNK_03' => 3,
        'TRUNK_04' => 4,  'TRUNK_05' => 5,  'TRUNK_06' => 6,
        'TRUNK_07' => 7,  'TRUNK_08' => 8,
        // House Branches (A = entry, B = climax before ending)
        'STARK_A' => 9,  'STARK_B' => 10,
        'LANN_A' => 11,  'LANN_B' => 12,
        'TARG_A' => 13,  'TARG_B' => 14,
        'BARA_A' => 15,  'BARA_B' => 16,
        'TYR_A' => 17,  'TYR_B' => 18,
        'MART_A' => 19,  'MART_B' => 20,
        'TUL_A' => 21,  'TUL_B' => 22,
        'ARR_A' => 23,  'ARR_B' => 24,
        'GREY_A' => 25,  'GREY_B' => 26,
        // Commoner Branch
        'COMM_A' => 27,  'COMM_B' => 28,
        // Endings
        'END_COMM_GOOD' => 29,
        'END_COMM_BAD' => 30,
        'END_COMM_DEBT' => 31,
        'END_COMM_HONOR' => 32,
        'END_STARK' => 33,
        'END_LANN' => 34,
        'END_TARG' => 35,
        'END_BARA' => 36,
        'END_TYR' => 37,
        'END_MART' => 38,
        'END_TUL' => 39,
        'END_ARR' => 40,
        'END_GREY' => 41,
    ];
}
