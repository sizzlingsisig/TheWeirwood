<?php

namespace App\Ai\Tools;

use App\Models\House;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class GetHouseTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get detailed information about a specific house by its ID. Includes all fields: name, motto, description, sigil image, and game stats.';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $id = $request->integer('id');
        $house = House::withTrashed()->find($id);

        if (! $house) {
            return 'This house has been destroyed - no record exists in the archives.';
        }

        $status = $house->trashed() ? 'Fallen (Archived)' : 'Active';

        $output = "=== {$house->name} ===\n";
        $output .= "Status: {$status}\n";

        if ($house->motto) {
            $output .= "Motto: \"{$house->motto}\"\n";
        }

        if ($house->description) {
            $output .= "\n{$house->description}\n";
        }

        $output .= "\n--- Game Stats ---\n";
        $output .= "Honor: {$house->starting_honor}\n";
        $output .= "Power: {$house->starting_power}\n";
        $output .= "Debt: {$house->starting_debt}\n";

        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->required()->description('The house ID to retrieve'),
        ];
    }
}
