<?php

namespace App\Ai\Tools;

use App\Models\House;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class ListHousesTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'List all active houses in the game database. Returns house ID, name, motto, and starting stats (honor, power, debt).';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $houses = House::all(['id', 'name', 'motto', 'starting_honor', 'starting_power', 'starting_debt']);

        if ($houses->isEmpty()) {
            return 'No active houses found in the archives.';
        }

        $output = "Active Houses in the Archives:\n\n";

        foreach ($houses as $house) {
            $output .= "{$house->id}. {$house->name}";
            if ($house->motto) {
                $output .= " - \"{$house->motto}\"";
            }
            $output .= "\n";
            $output .= "   Honor: {$house->starting_honor} | Power: {$house->starting_power} | Debt: {$house->starting_debt}\n\n";
        }

        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
