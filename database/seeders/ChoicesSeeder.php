<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChoicesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $n = NodeIds::$map;

        // [from, to, order, req_house, text, hint, honor, power, debt, locks_high_debt]
        $choices = [
            // (Copied in full from StorySeeder.php, see previous message for full array)
            // ... (All ~90 choices from StorySeeder.php go here, as in the previous message) ...
        ];

        foreach ($choices as $idx => $row) {
            [
                $from, $to, $order, $reqHouse,
                $text, $hint,
                $honor, $power, $debt, $locks
            ] = $row;

            DB::table('choices')->updateOrInsert(
                ['from_node_id' => $from, 'display_order' => $order],
                [
                    'from_node_id'       => $from,
                    'to_node_id'         => $to,
                    'display_order'      => $order,
                    'required_house_id'  => $reqHouse,
                    'choice_text'        => $text,
                    'hint_text'          => $hint,
                    'honor_delta'        => $honor,
                    'power_delta'        => $power,
                    'debt_delta'         => $debt,
                    'locks_on_high_debt' => $locks,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                    'deleted_at'         => null,
                ]
            );
        }
    }
}
