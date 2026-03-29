# Project Overview: The Weirwood

The Weirwood is a web-based, interactive political drama engine with roguelite progression. Players navigate a branching narrative where choices affect three core resources: **Honor, Power, and Debt**. The app features a playable "Simulator" frontend and an "Archivist" CMS backend.

---

## Lore: The Bastard's Return

You are the **bastard child of a Great House** — a Stark, Lannister, Targaryen, Baratheon, Tyrell, Martell, Tully, Arryn, or Greyjoy. Born of noble blood but denied the name, you were sent away as a child to live in obscurity.

Now, years later, your noble parent has summoned you to **King's Landing**. The realm is in turmoil: three Hands of the King have died in as many years, the crown is buried in debt to the Iron Bank, and the great houses circle each other like wolves.

**Your goal:** Navigate the deadly politics of the court, prove your worth, and either reclaim your house's legacy or forge your own path.

**The twist:** Each of the 9 Great House endings unlocks that house for future playthroughs, allowing you to experience the story from different bloodlines.

---

## Gameplay Summary

1. **Choose your house** (or let the quiz decide)
2. **Play through the story** — first chapters are shared, then branch based on your house
3. **Manage three resources:** Honor, Power, and Debt
4. **Watch the Iron Bank's debt compound** if you borrow too heavily
5. **Reach one of 13 endings** — 4 common endings + 9 house-specific endings

---

## The Rules

### 1. The Boundary Rules (Stat Clamping)

- **Honor** and **Power**: Strictly bound between 0 and 100. If a choice gives +20 but player is at 90, they cap at 100.
- **Debt**: Has a hard floor of 0 (cannot go negative), but can technically exceed 100 mathematically right before triggering game over.

### 2. The Iron Bank Rules (Debt Cascade)

Debt is the only stat that aggressively fights back against the player.

- **The Penalty**: If a choice adds debt (`debt_delta > 0`), the cost is multiplied based on the player's current total debt.
- **The Relief**: If a choice reduces debt (`debt_delta < 0`), the player pays it off at a 1:1 ratio (no multiplier).
- **The Thresholds**:
    - Under 40 Debt = 1.0x (Normal)
    - 40 to 59 Debt = 1.3x (Strained)
    - 60 to 79 Debt = 1.6x (Critical)
    - 80 to 99 Debt = 2.0x (Insolvency)

### 3. The Ruin Rules (Game Over States)

The game forcibly terminates if either failure state is reached at the end of a turn:

- **Honor hits 0**: Player is executed, betrayed, or exiled.
- **Debt hits 100**: The Iron Bank collects, or creditors crush the player's house.

### 4. The Visibility Rules (House Gating)

A player is only allowed to see or click a choice if:

- **Faction Check**: The choice's `required_house_id` must either be `null` (everyone), OR must match the player's current `house_id`.
- **Debt Lockout**: If `locks_on_high_debt` is true, the choice is hidden when player's debt is ≥ 90.

### 5. The Audit Rule (The Archivist's Ledger)

Every click must record:

- Exact state before the math (honor_before, power_before, debt_before)
- Exact state after the math (honor_after, power_after, debt_after)
- The debt multiplier applied (if any)
- Threshold crossings in the debt_events table

---

## User Experience

### The Guest Experience

The **Landing Page** serves as the front door for unauthenticated users. It features the game's title, a brief hook about the narrative and the Iron Bank, and clear buttons to log in or register.

### The Player Hub

The **Homepage** is the authenticated user's dashboard. It displays:

- Total runs completed
- Current active house
- A prominent "Start New Game" button

**PLAY** is the gateway to the game engine. Players select their starting path:

- **Map**: Choose a specific house
- **Quiz**: Answer questions to determine best fit
- **Blind/Wanderer**: Random start

The backend generates the Game record and pushes them into the narrative.

### The Player's Legacy

**Run History** displays past sessions in a chronological table showing:

- Final Honor, Power, and Debt
- Verdict received
- Clicking a run shows the detailed chronicle of that playthrough

**Houses Catalogue** displays unlocked faction sigils with starting stats. Locked houses are silhouetted to encourage replayability.

**Endings Catalogue** shows discovered narrative conclusions out of 13 total.

Both under a "Collections" dropdown in navigation.

### The Developer's Domain

**Admin Dashboard** is locked behind an administrator role. This is the Archivist command center for managing nodes, choices, and game content without database software.

---

## Data Models

### User

- `hasMany` Players
- `belongsToMany` Houses (unlocked via `house_user` pivot)

### Player

- `belongsTo` User
- `hasMany` Games

### House

- `hasMany` Games
- Starting stats: honor, power, debt
- Sigil artwork

### Node

- `hasMany` Choices (outgoing)
- `hasOne` Ending (optional)
- Narrative text, artwork, chapter label

### Choice

- `belongsTo` fromNode (origin)
- `belongsTo` toNode (destination)
- `belongsTo` requiredHouse (optional - gates content)
- Deltas: honor_delta, power_delta, debt_delta
- Boolean: locks_on_high_debt

### Game

- `belongsTo` Player
- `belongsTo` House
- `belongsTo` currentNode
- Stats: honor, power, debt
- `hasMany` GameSteps
- `hasMany` DebtEvents
- `hasOne` Run (when complete)

### GameStep

- `belongsTo` Game
- `belongsTo` Choice
- Records: honor_before/after, power_before/after, debt_before/after, debt_multiplier_applied

### DebtEvent

- `belongsTo` Game
- Records: event_type, debt_value_at_event, multiplier_used, triggered_at_node

### Run

- `belongsTo` Game
- Summary: final_honor, final_power, final_debt, steps_taken, is_victory
- Unlocks: unlocked_house_id

---

## Technology Stack

- **Framework:** Laravel 12 (PHP 8.4)
- **Database:** PostgreSQL
- **Authentication:** Laravel Breeze (Blade Stack)
- **Frontend:** Blade + Tailwind CSS
- **Game Engine:** App\Services\GameEngineService

---

## Routes Overview

| Route                           | Controller                | Description             |
| ------------------------------- | ------------------------- | ----------------------- |
| `/`                             | Home                      | Landing page            |
| `/dashboard`                    | Dashboard                 | Player hub              |
| `/games`                        | GameController@index      | Game list / Run history |
| `/games/start`                  | GameController@start      | Start new game          |
| `/games/{game}/play`            | GameController@play       | Play current node       |
| `/games/{game}/choice/{choice}` | GameController@makeChoice | Submit choice           |
| `/games/{game}/end`             | GameController@endGame    | Game over screen        |
| `/houses`                       | HouseController           | Houses catalogue        |
| `/nodes`                        | NodeController            | Archivist - Nodes       |
| `/choices`                      | ChoiceController          | Archivist - Choices     |
| `/players`                      | PlayerController          | Player management       |
