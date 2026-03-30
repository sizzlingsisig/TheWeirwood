<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ChoiceSeeder — The Weirwood Decision Simulator
 * ══════════════════════════════════════════════════════════════════
 * Full DAG edge seeder.
 * Idempotent — uses updateOrInsert on (from_node_id, display_order).
 *
 * DEPENDENCY: NodeSeeder must run first.
 *
 * MEDIUM TRIM VERSION — Merged Chapters
 * ──────────────────────────────────────────────────────────────────
 * Ch I+II merged: TRUNK_01-03 (was 10 nodes)
 * Ch III branching: TRUNK_04-08 (was TRUNK_11-15)
 * Flag payoffs integrated directly into branching choices
 * No separate flag-consequence nodes
 *
 * ──────────────────────────────────────────────────────────────────
 * COLUMNS ON choices TABLE
 * ──────────────────────────────────────────────────────────────────
 *
 * requirements_json  JSON|null
 *   Evaluated by GameEngineService before showing the choice.
 *   Supported keys (all optional, AND-combined):
 *     required_flag    string   game_flags.flag_key must exist for this game
 *     forbidden_flag   string   game_flags.flag_key must NOT exist
 *     min_honor        int      games.honor must be >= this value
 *     min_power        int      games.power must be >= this value
 *     max_debt         int      games.debt must be <= this value
 *     sets_flag        string   GameEngineService creates a game_flags row
 *
 * ──────────────────────────────────────────────────────────────────
 * FLAG SYSTEM OVERVIEW
 * ──────────────────────────────────────────────────────────────────
 *
 *  spared_thief
 *    Set:      TRUNK_01 order 4 (spare the boy)
 *    Required: TRUNK_07 order 4 (mercy council shortcut)
 *    Echoes:   STARK_A order 3, TUL_A order 3 (regional recognition)
 *    Forbidden: TRUNK_04 order 4 (ruthlessness check)
 *
 *  killed_thief
 *    Set:      TRUNK_01 order 5 (hand the boy)
 *    Required: TRUNK_04 order 4, BARA_A order 3, GREY_A order 3
 *    Forbidden: TRUNK_07 order 4, TARG_A order 4
 *
 *  found_secret_letter
 *    Set:      TRUNK_02 order 4 (search the saddlebags)
 *    Required: TRUNK_06 order 4, LANN_A order 3
 *
 * ──────────────────────────────────────────────────────────────────
 * NODE IDS (shifted for medium trim)
 * ──────────────────────────────────────────────────────────────────
 * Trunk 1-8 | House branches 9-28 | Endings 29-41
 */
class ChoicesSeeder extends Seeder
{
    private const N = [
        // Merged Ch I+II (3 nodes) → Ch III (5 nodes) = TRUNK_01-08
        'TRUNK_01' => 1, 'TRUNK_02' => 2, 'TRUNK_03' => 3,
        'TRUNK_04' => 4, 'TRUNK_05' => 5, 'TRUNK_06' => 6,
        'TRUNK_07' => 7, 'TRUNK_08' => 8,

        // House branches — shifted
        'STARK_A' => 9,  'STARK_B' => 10,
        'LANN_A' => 11,  'LANN_B' => 12,
        'TARG_A' => 13,  'TARG_B' => 14,
        'BARA_A' => 15,  'BARA_B' => 16,
        'TYR_A' => 17,   'TYR_B' => 18,
        'MART_A' => 19,  'MART_B' => 20,
        'TUL_A' => 21,   'TUL_B' => 22,
        'ARR_A' => 23,   'ARR_B' => 24,
        'GREY_A' => 25,  'GREY_B' => 26,
        'COMM_A' => 27,  'COMM_B' => 28,

        // Endings — shifted
        'END_COMM_GOOD' => 29, 'END_COMM_BAD' => 30,
        'END_COMM_DEBT' => 31, 'END_COMM_HONOR' => 32,
        'END_STARK' => 33, 'END_LANN' => 34,
        'END_TARG' => 35, 'END_BARA' => 36,
        'END_TYR' => 37, 'END_MART' => 38,
        'END_TUL' => 39, 'END_ARR' => 40,
        'END_GREY' => 41,
    ];

    public function run(): void
    {
        $now = Carbon::now();
        $n = self::N;

        // ROW FORMAT:
        // [ from, to, order, req_house_id,
        //   choice_text, hint_text,
        //   honor_delta, power_delta, debt_delta, locks_on_high_debt,
        //   requirements_json (JSON|null) ]

        $choices = [

            // ═══════════════════════════════════════════════════
            // CHAPTER I — THE JOURNEY (MERGED Ch I + Ch II)
            // TRUNK_01: Flag seeds (spared_thief, killed_thief)
            // TRUNK_02: found_secret_letter
            // TRUNK_03: City arrival + Council intro
            // ═══════════════════════════════════════════════════

            // TRUNK_01 → TRUNK_02
            [$n['TRUNK_01'], $n['TRUNK_02'], 1, null,
                'Accept the summons with public dignity — ride openly, banners flying.',
                'Costs nothing now. Signals everything.',
                +5, 0, 0, false, null],
            [$n['TRUNK_01'], $n['TRUNK_02'], 2, null,
                'Accept, but dispatch a spy ahead of your party to scout the capital.',
                'Knowledge is armor. Armor costs gold.',
                0, +5, +8, false, null],
            [$n['TRUNK_01'], $n['TRUNK_02'], 3, null,
                'Accept and begin quietly drafting political allies before you depart.',
                'Every alliance is a debt in waiting.',
                0, +8, +12, true, null],
            // Order 4: spare the thief — sets spared_thief
            [$n['TRUNK_01'], $n['TRUNK_02'], 4, null,
                'Tell the merchant: the boy keeps his hand. Compensate him from your own purse.',
                'Mercy is expensive. It compounds without interest.',
                +8, 0, +5, false,
                '{"sets_flag":"spared_thief"}'],
            // Order 5: give the boy — sets killed_thief
            [$n['TRUNK_01'], $n['TRUNK_02'], 5, null,
                'The law is the law. Let the merchant have his justice.',
                "Power without mercy is efficient. Until it isn't.",
                -8, +6, 0, false,
                '{"sets_flag":"killed_thief"}'],

            // TRUNK_02 → TRUNK_03  (found_secret_letter + house choices)
            [$n['TRUNK_02'], $n['TRUNK_03'], 1, null,
                'Ignore the strangers entirely and retire early.',
                'Not every shadow is a dagger.',
                +5, -5, 0, false, null],
            [$n['TRUNK_02'], $n['TRUNK_03'], 2, null,
                'Have your guard watch the strangers through the night.',
                'Vigilance costs sleep. Sleep is a luxury.',
                0, +8, +5, false, null],
            [$n['TRUNK_02'], $n['TRUNK_03'], 3, null,
                'Approach one of the strangers and reveal that you have noticed the meeting.',
                'Bold. Possibly fatal. Definitely memorable.',
                -5, +10, +8, false, null],
            // Order 4: search saddlebags — sets found_secret_letter
            [$n['TRUNK_02'], $n['TRUNK_03'], 4, null,
                "Send your most trusted servant to quietly search the riders' saddlebags while they drink.",
                'A letter unopened is a question unanswered.',
                +3, +5, +5, false,
                '{"sets_flag":"found_secret_letter"}'],
            // Order 5: dynamic house intimidation (min_power 40)
            [$n['TRUNK_02'], $n['TRUNK_03'], 5, null,
                'The name of [House] is enough. Let them see your sigil and draw their own conclusions.',
                'A reputation is cheaper than a sword and cuts deeper.',
                -3, +12, +5, false,
                '{"min_power":40}'],
            // Order 6: Lannister-specific coin intimidation
            [$n['TRUNK_02'], $n['TRUNK_03'], 6, 2,
                'Drop a single Lannister coin on the table where the riders can see it. Say nothing.',
                'The lion does not roar. The lion lets the gold speak.',
                -5, +15, +8, false,
                '{"min_power":35}'],

            // TRUNK_03 → TRUNK_04 (City arrival + Council)
            [$n['TRUNK_03'], $n['TRUNK_04'], 1, null,
                'Pay the gate toll without argument and offer a friendly word to the Gold Cloak.',
                'Small courtesies, small investments.',
                +3, 0, +5, false, null],
            [$n['TRUNK_03'], $n['TRUNK_04'], 2, null,
                'Invoke your title and demand immediate passage.',
                'Power asserted is power spent.',
                -5, +8, 0, false, null],
            [$n['TRUNK_03'], $n['TRUNK_04'], 3, null,
                'Bribe the captain and make note of his name for future leverage.',
                'Corruption begets corruption.',
                -8, +5, +12, true, null],
            // Order 4: Stark honor gate (min_honor 55)
            [$n['TRUNK_03'], $n['TRUNK_04'], 4, 1,
                "Invoke the ancient right of free passage for lords sworn to the King's Peace.",
                "The North's honor opens doors gold cannot.",
                +8, +5, 0, false,
                '{"min_honor":55}'],
            // Order 5: Greyjoy threat (min_power 60)
            [$n['TRUNK_03'], $n['TRUNK_04'], 5, 9,
                'Remind the captain that [House] ships are anchored three hundred yards from where he stands.',
                'Drowning men are poor testimony.',
                -10, +15, +5, false,
                '{"min_power":60}'],
            // Order 6: Martell formal courtesy (min_honor 50)
            [$n['TRUNK_03'], $n['TRUNK_04'], 6, 6,
                'Address the king in the Dornish fashion — the courtesy Dorne has never owed the Iron Throne.',
                'Respect given freely is worth more than respect extracted.',
                +10, +5, 0, false,
                '{"min_honor":50}'],

            // ═══════════════════════════════════════════════════
            // CHAPTER II — THE BRANCHING (was Ch III)
            // TRUNK_04-08: Political intrigue with integrated flag payoffs
            // ═══════════════════════════════════════════════════

            // TRUNK_04 → TRUNK_05 (King's illness)
            [$n['TRUNK_04'], $n['TRUNK_05'], 1, null,
                "Propose an immediate taxation reform to address the crown's debt.",
                'Popular with the poor. Catastrophic with the rich.',
                +10, -5, -10, false, null],
            [$n['TRUNK_04'], $n['TRUNK_05'], 2, null,
                'Suggest a controlled debt restructuring with the Iron Bank.',
                'Bankers have longer memories than kings.',
                0, +5, +15, true, null],
            [$n['TRUNK_04'], $n['TRUNK_05'], 3, null,
                'Quietly begin investigating where the debt money actually went.',
                'Follow the gold. The gold leaves tracks.',
                +5, +8, +8, false, null],
            // Order 4: killed_thief ruthlessness payoff
            [$n['TRUNK_04'], $n['TRUNK_05'], 4, null,
                "Move into the vacuum before anyone else does. Occupy the Hand's quarters and issue orders in the King's name.",
                'The ruthless inherit the earth. Or at least the anteroom.',
                -8, +20, +10, false,
                '{"required_flag":"killed_thief","min_power":50,"forbidden_flag":"spared_thief"}'],
            // Order 5: Tyrell grain offer (min_power 40)
            [$n['TRUNK_04'], $n['TRUNK_05'], 5, 5,
                "Propose offsetting the crown's grain debt through Highgarden's surplus — quietly.",
                'The Reach feeds the realm. Everyone knows it. Almost no one says it.',
                +5, +10, -5, false,
                '{"min_power":40}'],

            // TRUNK_05 → TRUNK_06 (Letter + Assassination)
            [$n['TRUNK_05'], $n['TRUNK_06'], 1, null,
                "Write back with reassurance and double your family's security quietly.",
                'Family is armor. Family is also leverage.',
                +5, +5, +10, false, null],
            [$n['TRUNK_05'], $n['TRUNK_06'], 2, null,
                'Ignore the letter — paranoia serves the people who plant it.',
                'Ignoring a warning is itself a decision.',
                0, 0, 0, false, null],
            [$n['TRUNK_05'], $n['TRUNK_06'], 3, null,
                'Send your most trusted person home to investigate the threat directly.',
                'Protecting home costs influence here.',
                +8, -5, +5, false, null],
            // Order 4: found_secret_letter — shows advantage
            [$n['TRUNK_05'], $n['TRUNK_06'], 4, null,
                'Re-read the letter from the inn alongside the letter from home. Something connects.',
                'You already know more than they think you know.',
                +5, +8, 0, false,
                '{"required_flag":"found_secret_letter"}'],
            // Order 5: Report assassination attempt
            [$n['TRUNK_05'], $n['TRUNK_06'], 5, null,
                'Report the assassination attempt to the King immediately and loudly.',
                'Public sympathy is a form of armor.',
                +8, 0, +5, false, null],
            // Order 6: Targaryen fire-response (forbidden_flag killed_thief)
            [$n['TRUNK_05'], $n['TRUNK_06'], 6, 3,
                'Publicly name the bolt as a political act and invoke the Valyrian right to answer fire with fire.',
                'Dragons do not hide from the dark. They illuminate it.',
                -5, +18, +8, false,
                '{"forbidden_flag":"killed_thief"}'],

            // TRUNK_06 → TRUNK_07 (Confession + Feast)
            [$n['TRUNK_06'], $n['TRUNK_07'], 1, null,
                'Move to the Sept immediately. You know what the dying septon will say before he says it.',
                'Foreknowledge is the rarest armor.',
                +5, +10, 0, false, null],
            [$n['TRUNK_06'], $n['TRUNK_07'], 2, null,
                'Verify the name through your own contacts first — one more day will not matter.',
                'Patience has always been the better part of intelligence.',
                +8, +5, +5, false, null],
            [$n['TRUNK_06'], $n['TRUNK_07'], 3, null,
                'Go to the Sept and hope the context arrives with you.',
                'Improvise. It has worked before.',
                0, +5, +5, false, null],
            // Order 4: found_secret_letter prepared verdict (min_honor 45)
            [$n['TRUNK_06'], $n['TRUNK_07'], 4, null,
                'You already know where this leads. Skip the verification and move directly to the source.',
                'The prepared mind sees the trap before it springs.',
                +10, +12, -5, false,
                '{"required_flag":"found_secret_letter","min_honor":45}'],
            // Order 5: Lannister monetize the information (min_power 45)
            [$n['TRUNK_06'], $n['TRUNK_07'], 5, 2,
                'The name on the parchment is worth money. Find out who will pay the most to keep it quiet.',
                'Information is the only currency that pays compound interest.',
                -8, +15, +12, false,
                '{"min_power":45}'],
            // Order 6: Perform the social game at feast
            [$n['TRUNK_06'], $n['TRUNK_07'], 6, null,
                'Use the feast to quietly arrange three private meetings for tomorrow.',
                'Politics happens between the dances.',
                0, +8, +10, false, null],
            // Order 7: Arryn honor speech (min_honor 60)
            [$n['TRUNK_06'], $n['TRUNK_07'], 7, 8,
                'Use the feast as a dais. Speak plainly about the law, as the Eyrie has always spoken.',
                'As high as honor — and at a feast, that is very high indeed.',
                +15, +5, 0, false,
                '{"min_honor":60}'],

            // TRUNK_07 → TRUNK_08 (Council of banners — flag payoffs integrated)
            [$n['TRUNK_07'], $n['TRUNK_08'], 1, null,
                'Take the chair. Lead the council openly.',
                'Leadership is visible. Visibility is dangerous.',
                +5, +8, +5, false, null],
            [$n['TRUNK_07'], $n['TRUNK_08'], 2, null,
                'Decline the chair, but broker a compromise between factions.',
                'Kingmakers outlive kings.',
                +8, +5, +8, false, null],
            [$n['TRUNK_07'], $n['TRUNK_08'], 3, null,
                'Observe and say nothing — let others reveal their positions first.',
                'Silence is information.',
                0, +5, 0, false, null],
            // Order 4: spared_thief mercy shortcut — integrated payoff (min_honor 55)
            [$n['TRUNK_07'], $n['TRUNK_08'], 4, null,
                'A shadow slips through the door — the boy from the Crossroads. He sets a sealed document on your desk without a word. Present the names to the council — bought with mercy, worth more than any bribe.',
                'What you gave without expecting return has returned everything.',
                +15, +10, -5, false,
                '{"required_flag":"spared_thief","min_honor":55,"forbidden_flag":"killed_thief"}'],
            // Order 5: killed_thief — integrated merchant problem
            [$n['TRUNK_07'], $n['TRUNK_08'], 5, null,
                'Excuse yourself briefly — the merchant from the Crossroads has arrived and needs to be dealt with before he reaches anyone important. Pay him to leave.',
                'Old sins move faster when you are standing still.',
                -5, +5, +15, false,
                '{"required_flag":"killed_thief"}'],
            // Order 6: Greyjoy iron price
            [$n['TRUNK_07'], $n['TRUNK_08'], 6, 9,
                'The weak scramble for succession. [House] simply acts. Take what is needed.',
                'We do not ask. We do not wait.',
                -10, +18, +8, false,
                '{"min_power":65}'],

            // TRUNK_08 — THE BRANCH POINT (to House nodes)
            [$n['TRUNK_08'], $n['STARK_A'],  1,  1, 'Call upon the Northern Lords. Winter is coming, and the North remembers every debt.', "Only those of the wolf's blood understand this call.", +10, +5, 0, false, null],
            [$n['TRUNK_08'], $n['LANN_A'],   2,  2, 'Invoke the Lannister name and the weight of Casterly Rock\'s gold.', 'Gold opens every door — for a price.', -5, +15, +15, true, null],
            [$n['TRUNK_08'], $n['TARG_A'],   3,  3, 'Send the secret word east, across the Narrow Sea.', 'Fire and blood have long memories.', 0, +10, +10, false, null],
            [$n['TRUNK_08'], $n['BARA_A'],   4,  4, 'Rally under the crowned stag and demand justice for the bloodline.', 'Fury, when justified, is unstoppable.', +8, +10, +5, false, null],
            [$n['TRUNK_08'], $n['TYR_A'],    5,  5, 'Send a rose to Highgarden and wait for it to bloom.', 'Patience is the most Tyrell of weapons.', +5, +8, +12, false, null],
            [$n['TRUNK_08'], $n['MART_A'],   6,  6, 'Reach out to Dorne with the ancient formula of respect and patience.', 'You cannot rush the sun.', +8, +5, 0, false, null],
            [$n['TRUNK_08'], $n['TUL_A'],    7,  7, 'Summon the river lords under family, duty, and honour.', 'Three words that have toppled kingdoms.', +10, +8, 0, false, null],
            [$n['TRUNK_08'], $n['ARR_A'],    8,  8, 'Send a falcon to the Eyrie and invoke the old mountain law.', 'The high places remember every oath sworn beneath them.', +10, +5, 0, false, null],
            [$n['TRUNK_08'], $n['GREY_A'],   9,  9, 'Light a signal fire on the harbor shore — the old code the ironborn still answer.', "The drowned god's children come when called, but not without cost.", -5, +15, +18, true, null],
            [$n['TRUNK_08'], $n['COMM_A'],  10, null, 'Stand alone. No banner, no house, no lord. Only your own judgment.', 'Freedom is a compass with no north.', +5, -5, 0, false, null],

            // ═══════════════════════════════════════════════════
            // CHAPTER IV — HOUSE BRANCH A → B
            // Flag echoes woven into each house's branch
            // ═══════════════════════════════════════════════════

            // STARK_A → STARK_B
            [$n['STARK_A'], $n['STARK_B'], 1, 1, "Accept the Northern lords' pledge and ride for Winterfell's crypts.", 'The truth is buried in cold stone.', +8, +5, 0, false, null],
            [$n['STARK_A'], $n['STARK_B'], 2, 1, "Demand the maester's evidence before committing to anything.", 'Trust but verify. Especially in the North.', +5, +5, +5, false, null],
            // Order 3: spared_thief echo — northern legend (min_honor 60)
            [$n['STARK_A'], $n['STARK_B'], 3, 1,
                'The lords mention the story of the thief on the road. Your mercy precedes you.',
                'In the North, mercy is not weakness. It is the mark of a lord worth following.',
                +15, +8, 0, false,
                '{"required_flag":"spared_thief","min_honor":60}'],

            // LANN_A → LANN_B
            [$n['LANN_A'], $n['LANN_B'], 1, 2, 'Refuse the gold — expose the chain of control it represents.', 'Courage is expensive when lions are involved.', +10, -5, -5, false, null],
            [$n['LANN_A'], $n['LANN_B'], 2, 2, 'Accept conditionally and use access to investigate the financial network.', 'Play their game. Know their rules.', -5, +10, +15, true, null],
            // Order 3: found_secret_letter — letter named a Lannister agent
            [$n['LANN_A'], $n['LANN_B'], 3, 2,
                "Name the agent whose name was on the letter from the inn. Watch the Lannister man's composure fracture.",
                'You came to this meeting with better information than they expected.',
                +5, +18, -5, false,
                '{"required_flag":"found_secret_letter","min_power":45}'],

            // TARG_A → TARG_B
            [$n['TARG_A'], $n['TARG_B'], 1, 3, "Agree to meet the exile's emissary in a neutral location.", 'Dragons do not negotiate. Their representatives do.', 0, +8, +8, false, null],
            [$n['TARG_A'], $n['TARG_B'], 2, 3, 'Demand proof of the bloodline before entertaining any agreement.', 'Fire and blood, but verification first.', +8, +5, +5, false, null],

            // BARA_A → BARA_B
            [$n['BARA_A'], $n['BARA_B'], 1, 4, "Agree to uncover and document the legitimacy proof at Storm's End.", 'Truth is the only weapon that outlasts swords.', +10, +5, +5, false, null],
            [$n['BARA_A'], $n['BARA_B'], 2, 4, 'Channel Baratheon fury — confront the rumor-mongers directly.', 'Fury is persuasive. It is also exhausting.', +5, +10, +8, false, null],
            // Order 3: killed_thief echo — Baratheon respects ruthlessness
            [$n['BARA_A'], $n['BARA_B'], 3, 4,
                'Lord Baratheon has heard of your road justice. He respects it. Lean into it.',
                'The stag and the sword recognize each other.',
                -5, +20, +5, false,
                '{"required_flag":"killed_thief","forbidden_flag":"spared_thief","min_power":55}'],

            // TYR_A → TYR_B
            [$n['TYR_A'], $n['TYR_B'], 1, 5, "Accept Lady Olenna's invitation to walk in the gardens privately.", 'Old women who survive in politics are worth listening to.', +5, +8, +5, false, null],
            [$n['TYR_A'], $n['TYR_B'], 2, 5, 'Offer the Tyrells a specific political concession as a show of good faith.', 'Roses smell sweetest when you give them something first.', 0, +5, +15, false, null],

            // MART_A → MART_B
            [$n['MART_A'], $n['MART_B'], 1, 6, 'Match the Dornish patience — say nothing, watch everything, for a week.', 'The sun sets on the impatient.', +8, +5, 0, false, null],
            [$n['MART_A'], $n['MART_B'], 2, 6, 'Offer Dorne something it has wanted for a generation: formal recognition.', 'Recognition costs nothing but pride.', +10, 0, +5, false, null],

            // TUL_A → TUL_B
            [$n['TUL_A'], $n['TUL_B'], 1, 7, 'Swear the River Oath on the spot, in the rain, without hesitation.', 'Tully honors are not made in comfortable rooms.', +12, 0, 0, false, null],
            [$n['TUL_A'], $n['TUL_B'], 2, 7, 'Accept the letter and request three days to prepare a worthy response.', 'Three days is enough time to save or doom an alliance.', +5, +5, +5, false, null],
            // Order 3: spared_thief echo — Tully bannerman witnessed the road mercy
            [$n['TUL_A'], $n['TUL_B'], 3, 7,
                "One of the bannermen saw what happened on the King's Road. He vouches for you without being asked.",
                'Family, duty, honour. He saw all three in a ditch on the road south.',
                +15, +8, 0, false,
                '{"required_flag":"spared_thief","min_honor":58}'],

            // ARR_A → ARR_B
            [$n['ARR_A'], $n['ARR_B'], 1, 8, 'Travel to the Eyrie and sit with the young lord for a full week.', 'Patience, here, is the point.', +10, 0, +5, false, null],
            [$n['ARR_A'], $n['ARR_B'], 2, 8, 'Send counsel by letter, testing whether the advisors filter it.', 'Letters reveal who controls the reader.', +5, +5, +5, false, null],

            // GREY_A → GREY_B
            [$n['GREY_A'], $n['GREY_B'], 1, 9, "Agree to the ironborn's terms and sail for Pyke at dawn.", 'The sea is indifferent to both courage and cowardice.', -5, +12, +12, false, null],
            [$n['GREY_A'], $n['GREY_B'], 2, 9, 'Counter-offer: you want the Fleet, not the men. Ships last longer.', 'Ironborn respect directness. Occasionally.', 0, +10, +15, true, null],
            // Order 3: killed_thief echo — ironborn respect decisive violence
            [$n['GREY_A'], $n['GREY_B'], 3, 9,
                'Tell them about the boy on the road — the iron way. They already know. They approve.',
                'The drowned god does not mourn the soft.',
                -12, +22, +8, false,
                '{"required_flag":"killed_thief","min_power":60}'],

            // COMM_A → COMM_B
            [$n['COMM_A'], $n['COMM_B'], 1, null, 'Approach the smallest faction first — build from the bottom of the board.', 'The smallest pieces take the longest to notice.', +8, +5, 0, false, null],
            [$n['COMM_A'], $n['COMM_B'], 2, null, 'Make a public statement of independence that both factions must respond to.', "The center of the board is valuable until it isn't.", +5, +5, +8, false, null],

            // ═══════════════════════════════════════════════════
            // CHAPTER IV → V — BRANCH B → ENDINGS (unchanged)
            // ═══════════════════════════════════════════════════

            [$n['STARK_B'], $n['END_STARK'], 1, 1, 'Reveal the proof openly in the name of justice.', 'Honor, even when it costs everything.', +15, -5, 0, false, null],
            [$n['STARK_B'], $n['END_STARK'], 2, 1, 'Use the proof as a political shield — control it without publicizing it.', 'Power through restraint.', -5, +15, +10, false, null],

            [$n['LANN_B'], $n['END_LANN'], 1, 2, 'Expose the financial conspiracy and destroy the mechanism.', 'Sometimes the only winning move is detonation.', +10, +5, -15, false, null],
            [$n['LANN_B'], $n['END_LANN'], 2, 2, 'Take control of the mechanism instead of destroying it.', 'A lion does not break the cage. A lion becomes the cage.', -10, +20, +15, true, null],

            [$n['TARG_B'], $n['END_TARG'], 1, 3, 'Swear your support openly and publicly.', 'There is no half-measure with fire.', -5, +10, +10, false, null],
            [$n['TARG_B'], $n['END_TARG'], 2, 3, 'Coordinate the return covertly — strike before the opposition can organize.', 'The dragon rises when the sun is still set.', -10, +15, +12, false, null],

            [$n['BARA_B'], $n['END_BARA'], 1, 4, 'Submit the proof to the Grand Maester with full ceremony.', 'The quill mightier than the hammer, this once.', +15, +5, 0, false, null],
            [$n['BARA_B'], $n['END_BARA'], 2, 4, 'Publish the proof widely before any opposition can suppress it.', 'A truth released cannot be un-released.', +10, +8, +5, false, null],

            [$n['TYR_B'], $n['END_TYR'], 1, 5, 'Accept the Tyrell offer and seal it with a public ceremony.', 'Public joy is harder to quietly undo.', +5, +10, +15, false, null],
            [$n['TYR_B'], $n['END_TYR'], 2, 5, 'Accept privately and implement the alliance quietly over months.', 'Gardens grow slowly. They also grow completely.', 0, +12, +8, false, null],

            [$n['MART_B'], $n['END_MART'], 1, 6, 'Sign the Sunspear Accord with full Dornish ceremony.', 'Ceremony matters to those who have been denied it.', +15, +5, 0, false, null],
            [$n['MART_B'], $n['END_MART'], 2, 6, 'Agree and immediately begin building trade infrastructure.', 'Peace is most durable when it is profitable.', +8, +8, +8, false, null],

            [$n['TUL_B'], $n['END_TUL'], 1, 7, 'Swear the full Tully Oath before witnesses from every major house.', 'Words said before witnesses become stone.', +15, +5, 0, false, null],
            [$n['TUL_B'], $n['END_TUL'], 2, 7, 'Swear and immediately ask what the Riverlands needs most right now.', 'An oath with action attached is worth ten with words alone.', +10, +10, +5, false, null],

            [$n['ARR_B'], $n['END_ARR'], 1, 8, 'Guide the young lord to close the Moon Door and open the gates.', 'The highest honor is tempering the highest power.', +15, -5, 0, false, null],
            [$n['ARR_B'], $n['END_ARR'], 2, 8, 'Replace the corrupted advisors with people loyal to the young lord directly.', 'The most lasting change is structural.', +8, +10, +5, false, null],

            [$n['GREY_B'], $n['END_GREY'], 1, 9, 'Seal the iron compact on the battlements with salt and stone.', 'The sea witnesses all oaths made above it.', -5, +15, +10, false, null],
            [$n['GREY_B'], $n['END_GREY'], 2, 9, 'Offer the ironborn permanent legal recognition of their raiding rights in exchange for the Fleet.', 'Give a kraken the deep sea and it will defend your shallows.', -10, +18, +20, true, null],

            [$n['COMM_B'], $n['END_COMM_GOOD'],  1, null, 'Broker a compromise between both factions without joining either.', 'The Wanderer who serves no one serves everyone.', +15, +5, -5, false, null],
            [$n['COMM_B'], $n['END_COMM_BAD'],   2, null, 'Make an error in judgment that hands the advantage to the wrong side.', 'Even good intentions navigate badly in the dark.', -10, -10, +10, false, null],
            [$n['COMM_B'], $n['END_COMM_DEBT'],  3, null, 'Borrow against the future one final time to force a short-term resolution.', 'The cascade begins here.', 0, +5, +30, true, null],
            [$n['COMM_B'], $n['END_COMM_HONOR'], 4, null, 'Stand firm on principle and refuse every compromise that costs your integrity.', 'Honor, even unto ruin.', +20, -15, 0, false, null],
        ];

        foreach ($choices as $row) {
            [
                $from, $to, $order, $reqHouse,
                $text, $hint,
                $honor, $power, $debt, $locks,
                $requirementsJson,
            ] = $row;

            DB::table('choices')->updateOrInsert(
                ['from_node_id' => $from, 'display_order' => $order],
                [
                    'from_node_id' => $from,
                    'to_node_id' => $to,
                    'display_order' => $order,
                    'required_house_id' => $reqHouse,
                    'choice_text' => $text,
                    'hint_text' => $hint,
                    'honor_delta' => $honor,
                    'power_delta' => $power,
                    'debt_delta' => $debt,
                    'locks_on_high_debt' => $locks,
                    'requirements_json' => $requirementsJson,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }

        $total = count($choices);
        $hasRequirements = count(array_filter($choices, fn ($r) => $r[10] !== null));
        $houseSpec = count(array_filter($choices, fn ($r) => $r[3] !== null));

        $this->command->info("ChoiceSeeder: {$total} choices seeded.");
        $this->command->table(['System', 'Count'], [
            ['Has requirements_json', $hasRequirements],
            ['House-specific',       $houseSpec],
        ]);
    }
}
