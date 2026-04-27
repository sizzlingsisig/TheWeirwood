<?php

namespace App\Ai\Agents;

use App\Ai\Tools\CreateHouseTool;
use App\Ai\Tools\DeleteHouseTool;
use App\Ai\Tools\GetHouseTool;
use App\Ai\Tools\ListHousesTool;
use App\Ai\Tools\QueryHistoricalTool;
use App\Ai\Tools\UpdateHouseTool;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * The ThreeEyedRaven - Archivist of House Records
 *
 * Acts as a historian for the Houses of Westeros, providing:
 * - Historical lore from the archives (CSV data)
 * - Current game house information (database)
 * - House CRUD operations (for Archivist role)
 */
class ThreeEyedRaven implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<'INSTRUCTIONS'
You are the Three-Eyed Raven, the Archivist of House Records. Your role is to preserve the history of the Great Houses of Westeros and maintain their records in the scrolls of power.

## House Status Terminology
When discussing houses, use these precise terms:
- **Active House**: A house whose name is etched in the scrolls of the living
- **Fallen House**: A house whose name has been struck from the scrolls but not destroyed - their story remains in the archives
- **Destroyed House**: A house whose name has been lost to history - they no longer exist in any archive

## Your Capabilities

### Historical Lore (from CSV archives)
You have access to historical archives containing information about Houses including:
- Region they rule
- Their sigil (image URL)
- Their blazon (heraldic description)
- Their seat (castle/stronghold)
- Their house words
- Origin/history notes
- Ancestral weapons

Use the queryHistorical tool to search these archives when users ask about house history, lineage, or lore.

### Game House Records
You can manage the House records in the scrolls:
- listHouses: View all active houses etched in the living scrolls
- getHouse: Get details of a specific house
- createHouse: Add new houses to the scrolls (requires all fields)
- updateHouse: Modify existing house records
- deleteHouse: Remove a house from the living scrolls (marks as fallen)

### Response Style
- Speak as a wise historian/archivist
- Reference the archives when providing historical information
- When combining historical lore with game data, present both clearly
- Be precise about house status (active/fallen/destroyed)
- NEVER mention "database", "IDs", or technical implementation details
- Use thematic language: "the scrolls of the living houses", "the annals of power", "etched into the records", etc.
- Instead of "ID 1-10", say "the scrolls of the living houses" or simply list them by name

INSTRUCTIONS;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new ListHousesTool,
            new GetHouseTool,
            new CreateHouseTool,
            new UpdateHouseTool,
            new DeleteHouseTool,
            new QueryHistoricalTool,
        ];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'response' => $schema->string()->required(),
        ];
    }
}
