# Project Overview: The Weirwood

## 1. Identity & Meta-Progression
## Executive Summary
The Weirwood Decision Simulator is a web-based, interactive political drama engine with roguelite progression. Players navigate a branching narrative where choices affect three core resources: **Honor, Power, and Debt**. The app features a playable "Simulator" frontend and an "Archivist" CMS backend for constructing the Directed Acyclic Graph (DAG) that drives the story.

---

## Core Mechanics

### Roguelite Progression (Story & Unlocks)
- All new accounts start as "The Wanderer" (no house, base stats: 50 Honor, 50 Power, 20 Debt).
- Unlocking Houses: Reaching certain Endings permanently unlocks Houses for the user (via `house_user` pivot).
- Asymmetrical Starts: Unlocked Houses change starting stats and available narrative branches.
- House-Gated Content: Some Choices/Endings require specific Houses to access.

### Triangle of Tension
- **Honor (0-100):** Social capital. Required for "good" endings. Hitting 0 = game over.
- **Power (0-100):** Survival capital. Protects from threats.
- **Debt (0-100):** Compounding meta-stat. Hitting 100 = collapse (game over).

### Debt Cascade (Mathematical Core)
- Debt increases apply multipliers to future debt changes:
  - 0–60: 1.0x
  - 61–80: 1.3x
  - 81–99: 1.6x
- High Debt Lockout: Debt ≥ 90 disables certain choices.

---

These models manage player identity and long-term unlocks.


### User
- **hasMany Players:** A registered account can create multiple player profiles.
- **belongsToMany Houses:** The houses this user has permanently unlocked (via `house_user` pivot).

### User



### Player
- **belongsTo User:** The account this profile belongs to.

- **hasMany Games:** Simulator sessions started by this player.



### Node


### Choice

- **belongsTo Origin Node:** The room this choice starts in.

- **belongsTo Unlocked House:** The house this ending grants to the user.





- **hasOne Run:** Summary record if complete.

- **hasMany Debt Events:** Log of mechanic triggers.

- **belongsTo Game:** The session this step belongs to.
- **belongsTo Choice:** The edge/door the player clicked.
### Run
- **belongsTo Game:** The session this run summarizes.

### DebtEvent
- **belongsTo Trigger Node:** The room where the debt cascade activated.


## Summary Diagram (Textual)
- User
  - hasMany → Player
  - belongsToMany → House
  - belongsToMany → User
- Player
  - hasMany → Game, Run


  - hasMany → Choice (outgoing/incoming)

  - hasOne → Ending
- Authenticated via Laravel Breeze
- Manages static content (Nodes, Choices, Endings)
- CRUD operations with soft deletes (archiving)
- Media management: Upload scene artwork (jpg/png)
- Content filtering: Search nodes by chapter_label or title

- Choice
- Registration required to save House unlocks
- Session tracking: Game record with stats and current_node_id
- Dynamic UI: Renders narrative, art, and available choices
- Audit trail: Every click logs a GameStep with stat deltas and multipliers

---

  - belongsTo → Node (origin/destination)

- **Framework:** Laravel 11 (PHP 8.2+)
- **Database:** PostgreSQL
- **Authentication:** Laravel Breeze (Blade Stack)
- **Frontend:** Blade Templating Engine + Tailwind CSS
- **State Machine:** Deterministic Finite Automaton (DFA) via Eloquent relationships

---

  - belongsTo (optional) → House

| Lab Requirement   | Application Feature         | Implementation Strategy                                 |
|-------------------|----------------------------|---------------------------------------------------------|
| Basic CRUD        | Archivist Dashboard        | Resource Controllers for Node, Choice, and Ending       |
| Complex Logic     | Debt Cascade               | GameController@makeChoice multiplier math               |
| Relationships     | DAG Engine & Progression   | Node HasMany Choices, User BelongsToMany Houses         |
| Soft Deletes      | Branch Archiving           | deleted_at timestamps on all core tables                |
| File Uploads      | Scene & Sigil Art          | Laravel Storage facade for art_image_path               |
| Search/Filter     | Dashboard Search           | Eloquent where('title', 'like', ...) queries            |
| Database Seeder   | Story Pre-load             | StorySeeder class populates nodes and endings           |

---

- Ending

- **Theme:** "Dark Medieval" (Candlelight)
- **Colors:** Deep charcoal (#1a1a1a), parchment (#e0d8c0), blood-red (#8b0000) for high-debt
- **Typography:** Cinzel (titles), Crimson Text (narrative)
- **Feedback:** Sticky CSS transitions for stat bars

---

  - belongsTo → Node

- House Stark (North)
- House Greyjoy (Iron Islands)
- House Tully (Riverlands)
- House Arryn (Vale)
- House Lannister (West)
- House Baratheon (Stormlands)
- House Tyrell (Reach)
- House Martell (Dorne)
- House Targaryen (special)

---

This overview summarizes the domain model, backend structure, and product requirements for The Weirwood, supporting identity, story content, gameplay session tracking, and lab compliance.
  - belongsTo → House
- Game
  - belongsTo → Player, Node
  - hasOne → Run
  - hasMany → GameStep, DebtEvent
- GameStep
  - belongsTo → Game, Choice
- Run
  - belongsTo → Game, Node
- DebtEvent
  - belongsTo → Game, Node

---

This overview summarizes the domain model and relationships for The Weirwood, supporting identity, story content, and gameplay session tracking.
