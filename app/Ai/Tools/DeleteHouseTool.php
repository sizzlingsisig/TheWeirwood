<?php

namespace App\Ai\Tools;

use App\Models\House;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class DeleteHouseTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Soft delete a house, marking it as "fallen". The house will be moved to archives but can be restored.';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $id = $request->integer('id');
        $house = House::find($id);

        if (! $house) {
            return 'House not found. It may have already been destroyed.';
        }

        $houseName = $house->name;
        $house->delete();

        return "{$houseName} has fallen and been moved to the archives. The house can be restored if needed.";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->required()->description('The house ID to delete (soft delete)'),
        ];
    }
}
