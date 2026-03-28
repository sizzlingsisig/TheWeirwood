<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserHouseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        if (! $admin) {
            $this->command->warn('No admin user found. Skipping user houses seeding.');

            return;
        }

        $houseIds = House::pluck('id');
        $now = now();

        $attach = $houseIds->mapWithKeys(fn ($id) => [
            $id => ['unlocked_at' => $now],
        ])->toArray();

        $admin->houses()->syncWithoutDetaching($attach);
    }
}
