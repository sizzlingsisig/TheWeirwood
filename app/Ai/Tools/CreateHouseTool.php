<?php

namespace App\Ai\Tools;

use App\Models\House;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class CreateHouseTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Create a new house in the game. Required fields: name, motto, description, starting_honor (0-100), starting_power (0-100), starting_debt (0-100).';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:houses,name',
            'motto' => 'nullable|string|max:80',
            'description' => 'nullable|string',
            'starting_honor' => 'required|integer|min:0|max:100',
            'starting_power' => 'required|integer|min:0|max:100',
            'starting_debt' => 'required|integer|min:0|max:100',
        ]);

        $house = House::create($validated);

        $output = "✓ House successfully created and recorded in the archives.\n\n";
        $output .= "=== {$house->name} ===\n";

        if ($house->motto) {
            $output .= "Motto: \"{$house->motto}\"\n";
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
            'name' => $schema->string()->required()->description('The house name'),
            'motto' => $schema->string()->description('The house motto/words'),
            'description' => $schema->string()->description('Historical description of the house'),
            'starting_honor' => $schema->integer()->required()->description('Starting honor (0-100)'),
            'starting_power' => $schema->integer()->required()->description('Starting power (0-100)'),
            'starting_debt' => $schema->integer()->required()->description('Starting debt (0-100)'),
        ];
    }
}
