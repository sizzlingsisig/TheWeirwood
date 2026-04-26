<?php

namespace App\Ai\Tools;

use App\Models\House;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class UpdateHouseTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Update an existing house. Provide the house ID and the fields to update.';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $id = $request->integer('id');
        $house = House::find($id);

        if (! $house) {
            return 'House not found. It may have been destroyed.';
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:houses,name,'.$id,
            'motto' => 'sometimes|string|max:80',
            'description' => 'sometimes|string',
            'starting_honor' => 'sometimes|integer|min:0|max:100',
            'starting_power' => 'sometimes|integer|min:0|max:100',
            'starting_debt' => 'sometimes|integer|min:0|max:100',
        ]);

        $house->update($validated);
        $house->refresh();

        $output = "✓ House records updated.\n\n";
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
            'id' => $schema->integer()->required()->description('The house ID to update'),
            'name' => $schema->string()->description('New house name'),
            'motto' => $schema->string()->description('New house motto'),
            'description' => $schema->string()->description('New house description'),
            'starting_honor' => $schema->integer()->description('New starting honor (0-100)'),
            'starting_power' => $schema->integer()->description('New starting power (0-100)'),
            'starting_debt' => $schema->integer()->description('New starting debt (0-100)'),
        ];
    }
}
