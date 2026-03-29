
# Weirwood Simulator — Backend Implementation Plan

1. Landing & Entry
	- Route and controller for landing page with three entry options: House Quiz, Kingdom Map, Enter Blindly.
	- Basic Blade view with form/buttons for entry selection.

2. House Selection Prompt
	- On entry, check which houses the user has unlocked.
	- If user has unlocked more than just the commoner/default house, prompt them to pick from unlocked houses (form).
	- If only commoner/default is unlocked, skip prompt and start game as commoner.

3. House Selection List
	- Show a list of available houses for the user to pick from (form).
	- Each house displays its starting stats (honor, power, debt) and description.
	- After selection, create game with chosen house and redirect to game start.

4. Enter Blindly Flow
	- Allow direct entry with randomized or default stats, no house/region.
	- Redirect to game start.

5. Game Session & Node/Choice System
	- Model nodes and choices as a directed acyclic graph (DAG) in the database.
	- Each node: id, chapter, title, art, text, debt warning, choices[].
	- Each choice: text, costs (honor, power, debt), hint, next node.
	- Controller logic to update stats, log history, and move to next node on choice.

6. Endings
	- When reaching an ending node, show summary: verdict, ending title, ending text, final stats.
	- Option to restart or try a new fate.

7. History Trail
	- Store and display a trail of previous choices and nodes for the session.

8. Save/Resume & User Auth
	- Allow users to save progress and resume games.
	- Require authentication for persistent play.

9. Testing
	- Write feature and unit tests for all flows and logic.
- Use Form Requests for validation
- Document all endpoints and model relationships

---

**Start by scaffolding models and relationships, then implement core logic and admin features, followed by gameplay/session logic and thorough testing.**
