# The Weirwood - Product Requirements Document

## 1. Introduction

### 1.1 Purpose

The Weirwood is a branching narrative game where every choice has a price and every debt compounds. This document serves as both the Software Requirements Specification (SRS) and Product Requirements Document (PRD) for the project.

### 1.2 Scope

A text-based interactive fiction game set in a Westeros-inspired world where players make choices that affect their Honor, Power, and Debt stats. The game features multiple endings, house-specific storylines, and progression mechanics.

### 1.3 Definitions

| Term       | Definition                                             |
| ---------- | ------------------------------------------------------ |
| **Node**   | A single narrative scene/moment in the story           |
| **Choice** | A decision point that leads to different nodes         |
| **House**  | One of the Great Houses that can be played             |
| **Run**    | A completed game session (win or lose)                 |
| **Ending** | A final narrative node that concludes the story        |
| **Honor**  | Player stat representing moral standing                |
| **Power**  | Player stat representing political/military influence  |
| **Debt**   | Player stat representing obligations; higher = riskier |

---

## 2. Product Overview

### 2.1 Vision

An immersive text-based RPG where players navigate political intrigue, make consequential choices, and discover 13 unique endings across 8 playable houses.

### 2.2 Target Users

- Fans of interactive fiction games
- Players who enjoy narrative-driven experiences
- Strategy game enthusiasts who like consequence management

### 2.3 Platform

- **Web Application**: Browser-based, responsive design
- **Backend**: Laravel 12 (PHP 8.4)
- **Frontend**: Blade templates + Alpine.js + Tailwind CSS
- **Database**: PostgreSQL

---

## 3. User Stories

### 3.1 Authentication

| ID   | Story                                                                           | Priority  |
| ---- | ------------------------------------------------------------------------------- | --------- |
| US-1 | As a new user, I want to register with email/password so I can save my progress | Must Have |
| US-2 | As a returning user, I want to log in so I can access my saved games            | Must Have |
| US-3 | As a user, I want to log out securely                                           | Must Have |

### 3.2 Gameplay

| ID   | Story                                                               | Priority    |
| ---- | ------------------------------------------------------------------- | ----------- |
| US-4 | As a player, I want to start a new game so I can begin my story     | Must Have   |
| US-5 | As a player, I want to make choices that affect my stats            | Must Have   |
| US-6 | As a player, I want to see my current Honor, Power, and Debt        | Must Have   |
| US-7 | As a player, I want to see narrative text and choices for each node | Must Have   |
| US-8 | As a player, I want debt warnings when my debt is high              | Should Have |
| US-9 | As a player, I want to continue or restart games                    | Should Have |

### 3.3 Progression

| ID    | Story                                                            | Priority    |
| ----- | ---------------------------------------------------------------- | ----------- |
| US-10 | As a player, I want to unlock new houses by completing endings   | Must Have   |
| US-11 | As a player, I want to view my discovered endings                | Should Have |
| US-12 | As a player, I want to track my progress (runs, endings, houses) | Should Have |
| US-13 | As a player, I want to see my game history/chronicle             | Should Have |

### 3.4 Archivist (Admin)

| ID    | Story                                                   | Priority   |
| ----- | ------------------------------------------------------- | ---------- |
| US-14 | As an admin, I want to manage houses                    | Could Have |
| US-15 | As an admin, I want to manage narrative nodes           | Could Have |
| US-16 | As an admin, I want to manage choices and their effects | Could Have |

---

## 4. Functional Requirements

### 4.1 Authentication

- **REQ-1**: Users can register with name, email, and password
- **REQ-2**: Users can log in with email and password
- **REQ-3**: Users can log out (redirects to landing page)
- **REQ-4**: Passwords must be hashed using bcrypt

### 4.2 Game Modes

- **REQ-5**: **Map Mode** - Select a specific house to play (requires house to be unlocked)
- **REQ-6**: **Blind Mode** - Random house selection for exploration

### 4.3 Stats System

- **REQ-7**: Each player has three stats: Honor, Power, Debt
- **REQ-8**: Starting values determined by selected house
- **REQ-9**: Choices modify stats by set amounts (honor_delta, power_delta, debt_delta)

### 4.4 Debt Multiplier

- **REQ-10**: Debt multiplier increases as debt rises:
    - 0-19: 1.0x
    - 20-39: 1.3x
    - 40-59: 1.6x
    - 60-79: 2.0x
    - 80-99: 2.5x
- **REQ-11**: Multiplier affects debt gained from choices
- **REQ-12**: High multiplier shows risk warnings

### 4.5 Choice System

- **REQ-13**: Choices have requirements (minimum honor/power, flags, house)
- **REQ-14**: Locked choices show why they're unavailable
- **REQ-15**: Choices can be filtered by house and debt level

### 4.6 Game Endings

- **REQ-16**: Debt >= 100 triggers ruin ending
- **REQ-17**: Reaching an ending node completes the game
- **REQ-18**: Completing an ending may unlock a new house
- **REQ-19**: All 13 endings must be discoverable

### 4.7 Progression Tracking

- **REQ-20**: Completed runs are saved to history
- **REQ-21**: Discovered endings are tracked per user
- **REQ-22**: Unlocked houses are tracked per user
- **REQ-23**: Dashboard shows statistics (runs, endings, houses)

### 4.8 Narrative Display

- **REQ-24**: Display chapter label when present
- **REQ-25**: Display scene title
- **REQ-26**: Display narrative text
- **REQ-27**: Display scene image when present
- **REQ-28**: Display available choices with stat changes
- **REQ-29**: Display locked choices with requirements

---

## 5. Non-Functional Requirements

### 5.1 Performance

- **NFR-1**: Page load time < 2 seconds
- **NFR-2**: Choice processing < 500ms

### 5.2 Security

- **NFR-3**: All routes require authentication except login/register
- **NFR-4**: CSRF protection on all forms
- **NFR-5**: SQL injection prevention via Eloquent

### 5.3 Usability

- **NFR-6**: Responsive design for mobile and desktop
- **NFR-7**: Intuitive navigation
- **NFR-8**: Clear feedback for game state

### 5.4 Accessibility

- **NFR-9**: Semantic HTML structure
- **NFR-10**: Sufficient color contrast

---

## 6. Data Model

### 6.1 Core Entities

```
User
├── id (PK)
├── name
├── email
├── password
├── is_admin
└── timestamps

Player
├── id (PK)
├── user_id (FK)
├── display_name
└── timestamps

Game
├── id (PK)
├── player_id (FK)
├── house_id (FK)
├── region_id (FK)
├── entry_mode (map|blind)
├── honor (int)
├── power (int)
├── debt (int)
├── current_node_id (FK)
├── is_complete (bool)
├── session_started
└── session_ended

Node
├── id (PK)
├── node_code
├── chapter_label
├── title
├── narrative_text
├── debt_warning_text
├── debt_warning_threshold
├── is_ending (bool)
└── timestamps

Choice
├── id (PK)
├── from_node_id (FK)
├── to_node_id (FK)
├── display_order
├── required_house_id (FK, nullable)
├── choice_text
├── hint_text
├── honor_delta
├── power_delta
├── debt_delta
├── locks_on_high_debt
└── requirements_json

House
├── id (PK)
├── name
├── motto
├── description
├── starting_honor
├── starting_power
├── starting_debt
└── timestamps

Region
├── id (PK)
├── name
├── house_id (FK)
├── starting_honor
├── starting_power
└── starting_debt

Run
├── id (PK)
├── game_id (FK)
├── player_id (FK)
├── house_id (FK)
├── region_id (FK)
├── starting_node_id (FK)
├── ending_node_id (FK)
├── final_honor
├── final_power
├── final_debt
├── steps_taken
├── is_victory
├── unlocked_house_id (FK)
└── completed_at

Ending
├── node_id (PK, FK)
├── verdict_label
├── ending_type (honor|power|debt|war|neutral)
├── ending_text
├── required_house_id (FK, nullable)
├── unlocks_house_id (FK, nullable)
└── timestamps

GameStep
├── id (PK)
├── game_id (FK)
├── choice_id (FK)
├── sequence_order
├── honor_before, power_before, debt_before
├── honor_after, power_after, debt_after
├── debt_multiplier_applied
└── chosen_at

GameFlag
├── id (PK)
├── game_id (FK)
├── flag_key
└── value (bool)

DebtEvent
├── id (PK)
├── game_id (FK)
├── event_type
├── debt_value_at_event
├── multiplier_used
├── triggered_at_node (FK)
└── occurred_at
```

---

## 7. API/Route Summary

| Method | Route                         | Controller                | Purpose        |
| ------ | ----------------------------- | ------------------------- | -------------- |
| GET    | /                             | LandingController         | Landing page   |
| GET    | /dashboard                    | DashboardController       | User dashboard |
| GET    | /games                        | GameController@index      | List games     |
| GET    | /games/create                 | GameController@create     | New game form  |
| POST   | /games/start                  | GameController@start      | Start new game |
| GET    | /games/{game}/play            | GameController@play       | Play game      |
| POST   | /games/{game}/choice/{choice} | GameController@makeChoice | Submit choice  |
| GET    | /games/{game}/end             | GameController@endGame    | View ending    |
| GET    | /endings                      | EndingController@index    | View endings   |

---

## 8. UI/UX Requirements

### 8.1 Pages

1. **Landing Page** - Introduction, login/register links
2. **Dashboard** - Stats overview, continue game, start new game
3. **Game Create** - Select mode (Map/Blind), select house
4. **Game Play** - Narrative, choices, stats display
5. **Endings Catalogue** - Discovered endings with hover preview

### 8.2 Visual Design

- **Theme**: Dark fantasy, parchment/parchment tones
- **Primary Colors**:
    - Blood: #8B0000
    - Ember: #C0392B
    - Gold: #B8860B
    - Bone: #E8DCC8
    - Parchment: #F5EDD8
    - Ash: #2A2520
    - Coal: #1A1512
    - Bark: #3D2B1F
- **Typography**:
    - Headings: Cinzel
    - Body: Crimson Text

### 8.3 Layouts

- **Game Layout**: Header with stats, full-screen narrative
- **App Layout**: Standard authenticated layout
- **Responsive**: Mobile-first design

---

## 9. Future Considerations

- Leaderboards
- Achievements
- Multiple playthrough save slots
- Sound/music integration
- Additional houses/endings
- Multiplayer shared stories
