<?php

namespace Database\Seeders;

use App\Models\Ending;
use App\Models\Game;
use App\Models\Run;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UnlockAllEndingsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        if (! $admin) {
            $this->command->warn('No admin user found. Skipping.');

            return;
        }

        $player = $admin->players()->first();

        if (! $player) {
            $this->command->warn('No player found for admin. Skipping.');

            return;
        }

        $endings = Ending::all();
        $now = Carbon::now();

        $this->command->info("Unlocking all endings for admin user ({$admin->name})...");

        foreach ($endings as $ending) {
            $houseId = $ending->required_house_id ?? 1;

            $game = Game::create([
                'player_id' => $player->id,
                'house_id' => $houseId,
                'region_id' => null,
                'current_node_id' => $ending->node_id,
                'honor' => 50,
                'power' => 50,
                'debt' => 30,
                'entry_mode' => 'blind',
                'is_complete' => true,
                'session_started' => $now->copy()->subHours(1),
                'session_ended' => $now,
            ]);

            if ($ending->unlocks_house_id && ! $admin->hasHouse($ending->unlockedHouse)) {
                $admin->houses()->attach($ending->unlocks_house_id, ['unlocked_at' => $now]);
            }

            Run::create([
                'game_id' => $game->id,
                'player_id' => $player->id,
                'house_id' => $houseId,
                'region_id' => null,
                'starting_node_id' => 1,
                'ending_node_id' => $ending->node_id,
                'final_honor' => 50,
                'final_power' => 50,
                'final_debt' => 30,
                'steps_taken' => 10,
                'is_victory' => true,
                'unlocked_house_id' => $ending->unlocks_house_id,
                'completed_at' => $now,
            ]);
        }

        $this->command->info("Created {$endings->count()} runs with all endings discovered.");
    }
}
