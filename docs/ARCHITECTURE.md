# The Weirwood - Architecture Documentation

## Overview

The Weirwood is a branching narrative game where every choice has a price and every debt compounds. Players navigate through a text-based adventure, making decisions that affect their Honor, Power, and Debt stats.

## System Architecture

```mermaid
graph TB
    subgraph "Client Layer"
        UI[View/Blade Templates]
        Alpine[Alpine.js]
    end

    subgraph "Laravel Application"
        HTTP[HTTP Requests]
        RT[Route Dispatcher]

        subgraph "Controllers"
            Auth[Auth Controllers]
            Game[GameController]
            Ending[EndingController]
            Dashboard[DashboardController]
        end

        subgraph "Services"
            GES[GameEngineService]
        end

        subgraph "Models"
            User
            Player
            Game
            Node
            Choice
            House
            Region
            Run
            Ending
            GameStep
            GameFlag
            DebtEvent
        end
    end

    subgraph "Database"
        PG[(PostgreSQL)]
    end

    UI --> HTTP
    Alpine --> HTTP
    HTTP --> RT
    RT --> Auth
    RT --> Game
    RT --> Ending
    RT --> Dashboard

    Game --> GES
    GES --> User
    GES --> Player
    GES --> Game
    GES --> Node
    GES --> Choice
    GES --> House
    GES --> GameStep
    GES --> GameFlag
    GES --> DebtEvent

    User --> Player
    Player --> Game
    Game --> Node
    Game --> House
    Game --> Region
    Game --> Run
    Node --> Choice
    Choice --> Node
    House --> Ending
    Run --> Ending
    Run --> House

    Game --> PG
    Node --> PG
    Choice --> PG
    House --> PG
    Region --> PG
    Run --> PG
    Ending --> PG
    GameStep --> PG
    GameFlag --> PG
    DebtEvent --> PG
    User --> PG
    Player --> PG
```

## Database Schema

```mermaid
erDiagram
    USERS ||--o{ PLAYERS : has
    PLAYERS ||--o{ GAMES : plays
    PLAYERS ||--o{ RUNS : completes
    GAMES ||--o{ GAME_STEPS : records
    GAMES ||--o{ GAME_FLAGS : tracks
    GAMES ||--o{ DEBT_EVENTS : logs
    GAMES }o--|| HOUSES : uses
    GAMES }o--|| REGIONS : located_in
    GAMES }o--|| NODES : current
    NODES ||--o{ CHOICES : offers
    CHOICES }o--|| NODES : leads_to
    CHOICES }o--|| HOUSES : requires
    HOUSES ||--o{ ENDINGS : unlocks
    HOUSES ||--o{ ENDINGS : requires
    REGIONS ||--o{ HOUSES : associated
    RUNS }o--|| HOUSES : ended_with
    RUNS }o--|| NODES : started_at
    RUNS }o--|| ENDINGS : reached
    RUNS }o--|| REGIONS : started_in
    USERS ||--o{ HOUSE_USER : unlocks
    HOUSE_USER }o--|| HOUSES : ""
```

## Game Flow

```mermaid
stateDiagram-v2
    [*] --> Start: User visits game
    Start --> SelectMode: Choose Map or Blind
    SelectMode --> CreateGame: Select House (Map) or Random (Blind)
    CreateGame --> Gameplay: Game created, first node loaded

    Gameplay --> MakeChoice: Player selects choice
    MakeChoice --> CheckRequirements: Validate choice requirements
    CheckRequirements --> Valid: Requirements met
    CheckRequirements --> Gameplay: Show error (requirements not met)

    Valid --> ProcessChoice: Apply stat changes
    ProcessChoice --> CheckDebt: Calculate debt multiplier
    CheckDebt --> CheckRuin: Debt >= 100?
    CheckRuin --> Ruin: Debt >= 100
    CheckRuin --> CheckEnding: Is ending node?
    CheckEnding --> Ending: Node is ending
    CheckEnding --> Gameplay: Load next node

    Ruin --> RunCreated: Create run record (is_victory=false)
    Ending --> RunCreated: Create run record

    RunCreated --> CheckUnlock: Does ending unlock new house?
    CheckUnlock --> UnlockHouse: New house unlocked
    CheckUnlock --> [*]: Return to dashboard

    UnlockHouse --> [*]: Return to dashboard
```

## Stats System

```mermaid
graph LR
    subgraph "Stats"
        H[Honor]
        P[Power]
        D[Debt]
    end

    subgraph "Debt Multiplier"
        DM1[1.0x<br/>Debt 0-19]
        DM2[1.3x<br/>Debt 20-39]
        DM3[1.6x<br/>Debt 40-59]
        DM4[2.0x<br/>Debt 60-79]
        DM5[2.5x<br/>Debt 80-99]
    end

    H --> Choice
    P --> Choice
    D --> Choice
    Choice --> DM1
    Choice --> DM2
    Choice --> DM3
    Choice --> DM4
    Choice --> DM5

    DM1 --> DebtIncrease
    DM2 --> DebtIncrease
    DM3 --> DebtIncrease
    DM4 --> DebtIncrease
    DM5 --> DebtIncrease

    DebtIncrease --> RiskLevel
    RiskLevel --> Warning
```

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.4)
- **Database**: PostgreSQL
- **Frontend**: Blade Templates + Alpine.js
- **Styling**: Tailwind CSS v4
- **Authentication**: Laravel Sanctum
- **Architecture**: MVC with Service Layer

## Key Services

### GameEngineService

Handles all game logic including:

- Processing player choices
- Calculating debt multipliers
- Checking choice requirements
- Managing game flags
- Creating run records

## API/Route Structure

```mermaid
graph LR
    subgraph "Public Routes"
        L[Landing: GET /]
        Login[Login: GET/POST /login]
        Register[Register: GET/POST /register]
    end

    subgraph "Authenticated Routes"
        Dash[Dashboard: GET /dashboard]
        Games[List: GET /games]
        GamesC[Create: GET /games/create]
        GamesS[Start: POST /games/start]
        GamesP[Play: GET /games/{game}/play]
        GamesCh[Choice: POST /games/{game}/choice/{choice}]
        GamesE[End: GET /games/{game}/end]
    end

    subgraph "Archivist Routes (Admin)"
        Houses[CRUD: /houses]
        Nodes[CRUD: /nodes]
        Choices[CRUD: /choices]
        Endings[CRUD: /endings]
    end

    L --> Auth
    Login --> Auth
    Register --> Auth
    Auth --> Dash
    Auth --> Games
    Games --> GamesC
    GamesC --> GamesS
    GamesS --> GamesP
    GamesP --> GamesCh
    GamesP --> GamesE
```

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/
│       │   ├── LoginController.php
│       │   └── ...
│       ├── GameController.php
│       ├── EndingController.php
│       ├── DashboardController.php
│       └── ...
├── Models/
│   ├── User.php
│   ├── Player.php
│   ├── Game.php
│   ├── Node.php
│   ├── Choice.php
│   ├── House.php
│   ├── Region.php
│   ├── Run.php
│   ├── Ending.php
│   ├── GameStep.php
│   ├── GameFlag.php
│   └── DebtEvent.php
├── Services/
│   └── GameEngineService.php
└── ...

resources/views/
├── games/
│   ├── play.blade.php
│   ├── create.blade.php
│   ├── index.blade.php
│   └── ending.blade.php
├── endings/
│   └── index.blade.php
├── components/
│   └── layouts/
│       ├── game.blade.php
│       └── app.blade.php
└── ...
```
