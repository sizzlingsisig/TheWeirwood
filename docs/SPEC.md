# Endings Guide

## Overview

The Weirwood features 13 unique endings, each representing a different fate based on your choices throughout the game. Endings are categorized by type and are tied to the Great Houses of Westeros.

## Ending Types

| Type        | Description                                       |
| ----------- | ------------------------------------------------- |
| **honor**   | Endings achieved through honorable choices        |
| **power**   | Endings achieved through political/military power |
| **debt**    | Endings triggered by excessive debt (ruin)        |
| **war**     | Endings involving conquest and conflict           |
| **neutral** | Endings available to any house                    |

## Complete Ending List

### Universal Endings (No House Required)

These endings can be achieved regardless of which house you play:

| #   | Verdict Label             | Type    | Description                                                                                                                                                                                                                   |
| --- | ------------------------- | ------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1   | A Life Quietly Well-Lived | neutral | History will not remember your name. But in the alleys and marketplaces where the smallfolk trade stories, a tale persists of a wanderer who came to the city with nothing, refused to be bought, and left with honor intact. |
| 2   | Exiled from the Game      | neutral | You survived, which is more than can be said for the last three Hands of the King. The gold cloak's escort rides with you to the city gate, and at the boundary stone, they turn back without a word.                         |
| 3   | Broken by the Cascade     | debt    | The debts compounded faster than you could pay them. Political debt, financial debt, the debt of promises made in the dark and called due in the daylight.                                                                    |
| 4   | The Saint No One Mourns   | honor   | You chose honor at every fork and arrived, honorably, at ruin. The system was not designed for honest players.                                                                                                                |

### House-Specific Endings

These endings require you to play as a specific house AND make choices aligned with that house's theme:

| #   | Verdict Label                    | House           | Unlocks         | Description                                                                                                                                                                                |
| --- | -------------------------------- | --------------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| 5   | Warden of the True North         | House Stark     | House Stark     | The direwolf banner flies over a city that respects it, finally, out of something more than fear. You played the older game — what a person does when winter comes and no one is watching. |
| 6   | The Architect of a Golden Age    | House Lannister | House Lannister | They will write that the realm was conquered by a lion. The truth, which only you and a handful of dead men know, is that it was purchased — ledger entry by ledger entry, debt by debt.   |
| 7   | Herald of the Returning Dragon   | House Targaryen | House Targaryen | You chose the fire and the fire was real. The dragon's return will be called a conquest by those who lost and a liberation by those who lived.                                             |
| 8   | Defender of the Stag's Line      | House Baratheon | House Baratheon | The rumors are silenced. The proof is entered into the grand maester's registry in triplicate. House Baratheon's claim, legitimate from the beginning, is now unassailable.                |
| 9   | Architect of the Flowering Court | House Tyrell    | House Tyrell    | Highgarden does not need the throne. It needs only to be indispensable to whoever sits on it, arranged with characteristic Tyrell elegance. The rose is not the most dangerous flower.     |
| 10  | Voice of the Unbroken            | House Martell   | House Martell   | The Sunspear Accord is the first honest peace the realm has seen in forty years — not a surrender, but a genuine acknowledgment that Dorne has always been different.                      |
| 11  | Bridge of the Realm              | House Tully     | House Tully     | The Riverlands stop burning. The trout banner flies over fords that armies have crossed in anger for generations, and this time, they cross in trade.                                      |
| 12  | The High Justiciar               | House Arryn     | House Arryn     | The Eyrie's justice has always fallen from a great height. You helped a young lord understand that justice ought also to be tempered with mercy.                                           |
| 13  | Breaker of Harbors               | House Greyjoy   | House Greyjoy   | The Iron Fleet is worth a hundred thousand soldiers when it appears where no one expects it. Your compact with the ironborn was mad and decisive.                                          |

## How to Unlock Endings

### Step 1: Unlock a House

Before you can access house-specific endings, you must first unlock the corresponding house by discovering its ending in a previous run.

**Initial State**: You start with no houses unlocked.

**How to Unlock**: Complete a run that reaches a house-specific ending. The house associated with that ending will be unlocked for future games.

### Step 2: Play as the House

Once a house is unlocked:

1. Go to **Begin Journey**
2. Select **Map Mode**
3. Choose the house you want to play
4. Make choices that align with that house's values

### Step 3: Reach the Ending

Each house has a unique path through the narrative. Make choices that:

- Align with the house's ideology (honor for Stark, power for Lannister, etc.)
- Lead to the specific ending node for that house

## Stat Requirements

Endings are influenced by your **Honor**, **Power**, and **Debt** stats:

| Stat                | Effect                                              |
| ------------------- | --------------------------------------------------- |
| **Honor**           | Required for honor-type endings                     |
| **Power**           | Required for power-type endings                     |
| **Debt**            | High debt (80+) triggers ruin/ending cascade        |
| **Debt Multiplier** | Increases as debt rises, making choices more costly |

### Debt Multiplier Tiers

| Debt Range | Multiplier | Risk Level |
| ---------- | ---------- | ---------- |
| 0-19       | 1.0x       | Low        |
| 20-39      | 1.3x       | Low        |
| 40-59      | 1.6x       | Medium     |
| 60-79      | 2.0x       | High       |
| 80-99      | 2.5x       | Very High  |
| 100+       | Ruin       | Game Over  |

## Discovery Tracker

On the **Dashboard**, you can track your progress:

- **Endings Discovered**: X / 13
- **Houses Unlocked**: X / 8

Visit the **Endings Catalogue** to see which endings you've discovered. Hover over any discovered ending to read its full text.

## Tips for Finding All Endings

1. **Play Blind Mode First**: Randomly explore to discover different paths
2. **Use Map Mode**: Once unlocked, play specific houses to get house-specific endings
3. **Watch Your Debt**: High debt leads to ruin endings
4. **Make Different Choices**: Replay the same house with different choice patterns
5. **Check Requirements**: Some choices require minimum Honor/Power levels

## House Unlock Progression

Suggested discovery order:

```
Start (No houses)
    ↓
Play blind → Discover any ending
    ↓
House X unlocked
    ↓
Play as House X → Get House X ending
    ↓
House Y unlocked
    ↓
...continue until all 13 endings discovered
```

## Technical Details

Endings are stored in the `endings` table with:

- `node_id` - The narrative node that triggers this ending
- `verdict_label` - The title of the ending
- `ending_type` - Category (honor/power/debt/war/neutral)
- `ending_text` - Full narrative text
- `required_house_id` - House needed to access (null = universal)
- `unlocks_house_id` - House unlocked by this ending
