<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class QueryHistoricalTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Search the historical archives (CSV) for information about Great Houses of Westeros. Searches across house name, region, blazon, words, origin, and notes.';
    }

    public function handle(AiRequest $request): Stringable|string
    {
        $query = strtolower($request->string('query'));

        $csvPath = storage_path('app/private/gameofthrones.csv');

        if (! file_exists($csvPath)) {
            return 'The historical archives are currently unavailable.';
        }

        $file = fopen($csvPath, 'r');
        $headers = fgetcsv($file);

        $results = [];

        while (($row = fgetcsv($file)) !== false) {
            $houseData = array_combine($headers, $row);
            $searchableText = implode(' ', array_map(function ($value) {
                return $value ?? '';
            }, $houseData));

            if (str_contains(strtolower($searchableText), $query)) {
                $results[] = $houseData;
            }
        }

        fclose($file);

        if (empty($results)) {
            return "No records found in the archives matching '{$query}'.";
        }

        // Limit to top 5 results
        $results = array_slice($results, 0, 5);

        $output = "Historical Archives - Matching Records:\n\n";

        foreach ($results as $house) {
            $output .= "--- {$house['House']} ---\n";

            if (! empty($house['Region'])) {
                $output .= "Region: {$house['Region']}\n";
            }
            if (! empty($house['Seat'])) {
                $output .= "Seat: {$house['Seat']}\n";
            }
            if (! empty($house['Words'])) {
                $output .= "Words: \"{$house['Words']}\"\n";
            }
            if (! empty($house['Blazon'])) {
                $output .= "Blazon: {$house['Blazon']}\n";
            }
            if (! empty($house['Origin'])) {
                $output .= "Origin: {$house['Origin']}\n";
            }
            if (! empty($house['Notes'])) {
                $output .= "Notes: {$house['Notes']}\n";
            }
            if (! empty($house['Ancestral weapon'])) {
                $output .= "Ancestral Weapon: {$house['Ancestral weapon']}\n";
            }

            $output .= "\n";
        }

        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->required()->description('Search query for house name, region, or keywords'),
        ];
    }
}
