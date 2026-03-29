<?php

namespace Database\Seeders;

class NodeIds
{
    public static array $map = [
        // Trunk
        'TRUNK_01' => 1,  'TRUNK_02' => 2,  'TRUNK_03' => 3,
        'TRUNK_04' => 4,  'TRUNK_05' => 5,  'TRUNK_06' => 6,
        'TRUNK_07' => 7,  'TRUNK_08' => 8,  'TRUNK_09' => 9,
        'TRUNK_10' => 10, 'TRUNK_11' => 11, 'TRUNK_12' => 12,
        'TRUNK_13' => 13, 'TRUNK_14' => 14, 'TRUNK_15' => 15,
        // House Branches (A = entry, B = climax before ending)
        'STARK_A'  => 16, 'STARK_B'  => 17,
        'LANN_A'   => 18, 'LANN_B'   => 19,
        'TARG_A'   => 20, 'TARG_B'   => 21,
        'BARA_A'   => 22, 'BARA_B'   => 23,
        'TYR_A'    => 24, 'TYR_B'    => 25,
        'MART_A'   => 26, 'MART_B'   => 27,
        'TUL_A'    => 28, 'TUL_B'    => 29,
        'ARR_A'    => 30, 'ARR_B'    => 31,
        'GREY_A'   => 32, 'GREY_B'   => 33,
        // Commoner Branch
        'COMM_A'   => 34, 'COMM_B'   => 35,
        // Endings
        'END_COMM_GOOD'    => 36,
        'END_COMM_BAD'     => 37,
        'END_COMM_DEBT'    => 38,
        'END_COMM_HONOR'   => 39,
        'END_STARK'        => 40,
        'END_LANN'         => 41,
        'END_TARG'         => 42,
        'END_BARA'         => 43,
        'END_TYR'          => 44,
        'END_MART'         => 45,
        'END_TUL'          => 46,
        'END_ARR'          => 47,
        'END_GREY'         => 48,
    ];
}
