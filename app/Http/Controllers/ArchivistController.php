<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ThreeEyedRaven;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArchivistController extends Controller
{
    /**
     * Query the Three-Eyed Raven (Archivist agent)
     */
    public function query(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|min:1',
        ]);

        $prompt = $request->string('prompt');

        try {
            $response = ThreeEyedRaven::make()->prompt($prompt);

            $text = $response->structured['response'];
            $html = Str::markdown($text, [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]);

            return response()->json([
                'response' => $html,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'The Archivist is unable to respond at this time.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
