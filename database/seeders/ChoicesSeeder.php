<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * ChoiceSeeder — The Weirwood Decision Simulator
 * ══════════════════════════════════════════════════════════════════
 * Seeds every DAG edge (choice) in the game. This seeder is
 * intentionally standalone — it can be run in isolation after
 * nodes already exist, or called from DatabaseSeeder as part of
 * a full fresh seed.
 *
 * DEPENDENCY: Nodes must exist before this runs.
 *   php artisan db:seed --class=StorySeeder   (seeds nodes)
 *   php artisan db:seed --class=ChoiceSeeder  (seeds choices)
 *
 * IDEMPOTENT: Uses updateOrInsert on (from_node_id, display_order),
 * which is the unique key defined in the migration. Safe to re-run.
 *
 * ──────────────────────────────────────────────────────────────────
 * CHOICE SCHEMA  (choices table)
 * ──────────────────────────────────────────────────────────────────
 *  from_node_id       FK → nodes.id   — origin node (DAG source)
 *  to_node_id         FK → nodes.id   — destination node (DAG sink)
 *  display_order      smallint        — render order within a node
 *  required_house_id  FK → houses.id  — null = visible to all
 *  choice_text        text            — the button label / action
 *  hint_text          varchar(255)    — flavour subtext shown to player
 *  honor_delta        smallint        — Δ honor on selection
 *  power_delta        smallint        — Δ power on selection
 *  debt_delta         smallint        — Δ debt BEFORE cascade multiplier
 *  locks_on_high_debt bool            — hidden when debt ≥ 90
 *
 * ──────────────────────────────────────────────────────────────────
 * DEBT CASCADE REMINDER  (applied by GameController, not here)
 * ──────────────────────────────────────────────────────────────────
 *  0–60   debt → 1.0× multiplier on debt_delta
 *  61–80  debt → 1.3× multiplier on debt_delta
 *  81–99  debt → 1.6× multiplier on debt_delta
 *  ≥ 90   debt → choices with locks_on_high_debt = true are hidden
 *
 * ──────────────────────────────────────────────────────────────────
 * DAG STRUCTURE  (91 choices total)
 * ──────────────────────────────────────────────────────────────────
 *
 * CHAPTER I  — Prologue           (5 trunk nodes × 3 choices = 15)
 *   TRUNK_01 → TRUNK_02   3 choices   (banners/spy/allies)
 *   TRUNK_02 → TRUNK_03   3 choices   (pace/smallfolk/bribe)
 *   TRUNK_03 → TRUNK_04   3 choices   (ignore/watch/confront)
 *   TRUNK_04 → TRUNK_05   3 choices   (pay/title/bribe)
 *   TRUNK_05 → TRUNK_06   3 choices   (bow/plain/flatter)
 *
 * CHAPTER II — Rising Tension     (5 trunk nodes × 3 choices = 15)
 *   TRUNK_06 → TRUNK_07   3 choices   (tax/bank/investigate)
 *   TRUNK_07 → TRUNK_08   3 choices   (trust/follow/ignore Varys)
 *   TRUNK_08 → TRUNK_09   3 choices   (confront/corrupt/broadcast)
 *   TRUNK_09 → TRUNK_10   3 choices   (report/guard/investigate)
 *   TRUNK_10 → TRUNK_11   3 choices   (neutral/king/meetings)
 *
 * CHAPTER III — The Branching     (5 trunk nodes × 3 choices = 15)
 *   TRUNK_11 → TRUNK_12   3 choices   (demand/council/investigate)
 *   TRUNK_12 → TRUNK_13   3 choices   (reassure/ignore/send home)
 *   TRUNK_13 → TRUNK_14   3 choices   (pursue/burn/share)
 *   TRUNK_14 → TRUNK_15   3 choices   (chair/broker/observe)
 *   TRUNK_15 → branches   10 choices  (9 house-gated + 1 commoner)
 *
 * CHAPTER IV — House Quests (branch A → B)
 *   9 houses × 2 choices             = 18
 *   commoner × 2 choices             =  2
 *                                    ────
 *                                      20
 *
 * CHAPTER IV → V (branch B → ending)
 *   9 houses × 2 choices             = 18
 *   commoner → 4 endings             =  4
 *                                    ────
 *                                      22
 *
 * TOTAL: 15 + 15 + 15 + 10 + 20 + 22 = 97 choices
 * (Note: TRUNK_15 branch-point has 10 outgoing edges counted separately)
 *
 * ──────────────────────────────────────────────────────────────────
 * NODE ID REFERENCE
 * ──────────────────────────────────────────────────────────────────
 * Trunk       1–15
 * STARK_A/B   16, 17   LANN_A/B    18, 19   TARG_A/B    20, 21
 * BARA_A/B    22, 23   TYR_A/B     24, 25   MART_A/B    26, 27
 * TUL_A/B     28, 29   ARR_A/B     30, 31   GREY_A/B    32, 33
 * COMM_A/B    34, 35
 * END_COMM_GOOD 36  END_COMM_BAD 37  END_COMM_DEBT 38  END_COMM_HONOR 39
 * END_STARK 40  END_LANN 41  END_TARG 42  END_BARA 43  END_TYR 44
 * END_MART  45  END_TUL  46  END_ARR  47  END_GREY  48
 */
class ChoicesSeeder extends Seeder
{
    // ── Node ID map ───────────────────────────────────────────────
    private const N = [
        'TRUNK_01' =>  1, 'TRUNK_02' =>  2, 'TRUNK_03' =>  3,
        'TRUNK_04' =>  4, 'TRUNK_05' =>  5, 'TRUNK_06' =>  6,
        'TRUNK_07' =>  7, 'TRUNK_08' =>  8, 'TRUNK_09' =>  9,
        'TRUNK_10' => 10, 'TRUNK_11' => 11, 'TRUNK_12' => 12,
        'TRUNK_13' => 13, 'TRUNK_14' => 14, 'TRUNK_15' => 15,

        'STARK_A'  => 16, 'STARK_B'  => 17,
        'LANN_A'   => 18, 'LANN_B'   => 19,
        'TARG_A'   => 20, 'TARG_B'   => 21,
        'BARA_A'   => 22, 'BARA_B'   => 23,
        'TYR_A'    => 24, 'TYR_B'    => 25,
        'MART_A'   => 26, 'MART_B'   => 27,
        'TUL_A'    => 28, 'TUL_B'    => 29,
        'ARR_A'    => 30, 'ARR_B'    => 31,
        'GREY_A'   => 32, 'GREY_B'   => 33,
        'COMM_A'   => 34, 'COMM_B'   => 35,

        'END_COMM_GOOD'  => 36, 'END_COMM_BAD'   => 37,
        'END_COMM_DEBT'  => 38, 'END_COMM_HONOR' => 39,
        'END_STARK'      => 40, 'END_LANN'        => 41,
        'END_TARG'       => 42, 'END_BARA'        => 43,
        'END_TYR'        => 44, 'END_MART'        => 45,
        'END_TUL'        => 46, 'END_ARR'         => 47,
        'END_GREY'       => 48,
    ];

    public function run(): void
    {
        $now = Carbon::now();
        $n   = self::N;

        // ──────────────────────────────────────────────────────────
        // Row format:
        // [from_node_id, to_node_id, display_order, required_house_id,
        //  choice_text, hint_text,
        //  honor_delta, power_delta, debt_delta, locks_on_high_debt]
        //
        // required_house_id : null = visible to all players
        //                     1–9  = only visible to that house
        //
        // locks_on_high_debt: true = choice is hidden when debt ≥ 90
        //                     These are always the greediest options.
        // ──────────────────────────────────────────────────────────
        $choices = [

            // ══════════════════════════════════════════════════════
            // CHAPTER I — PROLOGUE
            // Five nodes on the trunk. Every player sees these.
            // Tone: arriving in King's Landing, first impressions.
            // Design goal: establish that honor/power/debt are in
            // constant tension from the very first click.
            // ══════════════════════════════════════════════════════

            // ── TRUNK_01 → TRUNK_02 ── The Raven Arrives → The Road South ──
            // Three approaches to answering the royal summons.
            // Order 1: public dignity (safe, small honor gain)
            // Order 2: dispatch a spy (intelligence at debt cost)
            // Order 3: draft allies first (power gain, high debt, locked at ≥90)
            [
                $n['TRUNK_01'], $n['TRUNK_02'], 1, null,
                'Accept the summons with public dignity — ride openly, banners flying.',
                'Costs nothing now. Signals everything.',
                +5, 0, 0, false,
            ],
            [
                $n['TRUNK_01'], $n['TRUNK_02'], 2, null,
                'Accept, but dispatch a spy ahead of your party to scout the capital.',
                'Knowledge is armor. Armor costs gold.',
                0, +5, +8, false,
            ],
            [
                $n['TRUNK_01'], $n['TRUNK_02'], 3, null,
                'Accept and begin quietly drafting political allies before you depart.',
                'Every alliance is a debt in waiting.',
                0, +8, +12, true,
            ],

            // ── TRUNK_02 → TRUNK_03 ── The Road South → The Inn at the Crossroads ──
            // How you travel signals who you are.
            // Order 1: ride hard (power, debt)
            // Order 2: speak to smallfolk (honor, no cost)
            // Order 3: bribe innkeepers ahead (minor power, debt)
            [
                $n['TRUNK_02'], $n['TRUNK_03'], 1, null,
                'Ride hard and fast — arrive before your enemies expect you.',
                'Speed sacrifices caution.',
                0, +5, +5, false,
            ],
            [
                $n['TRUNK_02'], $n['TRUNK_03'], 2, null,
                'Ride slowly, speaking to smallfolk at each village to build a reputation.',
                'The common people remember.',
                +8, 0, 0, false,
            ],
            [
                $n['TRUNK_02'], $n['TRUNK_03'], 3, null,
                'Send your household steward ahead with coin to buy favorable innkeepers.',
                'Bribery is cheaper than war. Barely.',
                0, +3, +10, false,
            ],

            // ── TRUNK_03 → TRUNK_04 ── The Inn → The Gates of King's Landing ──
            // Three cloaked riders. Do you engage?
            // Order 1: ignore (small honor, power loss — prudent cowardice)
            // Order 2: watch through the night (power gain, small debt)
            // Order 3: confront them openly (big power gain, honor/debt cost)
            [
                $n['TRUNK_03'], $n['TRUNK_04'], 1, null,
                'Ignore the strangers entirely and retire early.',
                'Not every shadow is a dagger.',
                +5, -5, 0, false,
            ],
            [
                $n['TRUNK_03'], $n['TRUNK_04'], 2, null,
                'Have your guard watch the strangers through the night and report in the morning.',
                'Vigilance costs sleep. Sleep is a luxury.',
                0, +8, +5, false,
            ],
            [
                $n['TRUNK_03'], $n['TRUNK_04'], 3, null,
                'Approach one of the strangers and reveal that you have noticed the meeting.',
                'Bold. Possibly fatal. Definitely memorable.',
                -5, +10, +8, false,
            ],

            // ── TRUNK_04 → TRUNK_05 ── The Gates → The Red Keep ──
            // The Gold Cloak demands a toll. First test of your posture in the city.
            // Order 1: pay politely (honor+, small debt)
            // Order 2: invoke title (power+, honor-)
            // Order 3: bribe + leverage (power+, honor-, debt+, locked at ≥90)
            [
                $n['TRUNK_04'], $n['TRUNK_05'], 1, null,
                'Pay the gate toll without argument and offer a friendly word to the Gold Cloak.',
                'Small courtesies, small investments.',
                +3, 0, +5, false,
            ],
            [
                $n['TRUNK_04'], $n['TRUNK_05'], 2, null,
                'Invoke your title and demand immediate passage.',
                'Power asserted is power spent.',
                -5, +8, 0, false,
            ],
            [
                $n['TRUNK_04'], $n['TRUNK_05'], 3, null,
                'Bribe the captain and make note of his name for future leverage.',
                'Corruption begets corruption.',
                -8, +5, +12, true,
            ],

            // ── TRUNK_05 → TRUNK_06 ── The Red Keep → The Small Council ──
            // First audience before the King. Sets the tone for your entire tenure.
            // Order 1: bow deeply (honor+, safe)
            // Order 2: speak plainly (power+, small debt — competent but costs)
            // Order 3: flatter + study the room (power+, honor- — the political actor)
            [
                $n['TRUNK_05'], $n['TRUNK_06'], 1, null,
                'Bow deeply and offer measured words of loyalty.',
                'A king expects deference. A wise king notices sincerity.',
                +8, 0, 0, false,
            ],
            [
                $n['TRUNK_05'], $n['TRUNK_06'], 2, null,
                'Speak plainly and offer a specific policy solution immediately.',
                'Competence is currency in this hall.',
                0, +10, +5, false,
            ],
            [
                $n['TRUNK_05'], $n['TRUNK_06'], 3, null,
                'Flatter the king with elaborate theater and use the moment to study the room.',
                'The actor survives. The honest man does not always.',
                -5, +5, +8, false,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER II — THE RISING TENSION
            // The city begins to reveal its true shape. Each node
            // introduces a specific political threat: the crown's
            // debt, Varys, the Gold Cloaks, an assassination attempt,
            // and the feast as a social battlefield.
            // ══════════════════════════════════════════════════════

            // ── TRUNK_06 → TRUNK_07 ── The Small Council → The Spider's Web ──
            // The crown is four million dragons in debt. Your first major policy choice.
            // Order 1: taxation reform (honor+, power-, debt- — the honest path)
            // Order 2: Iron Bank restructure (power+, big debt, locked — the banker's trap)
            // Order 3: investigate the debt (honor+, power+ — the detective path)
            [
                $n['TRUNK_06'], $n['TRUNK_07'], 1, null,
                'Propose an immediate taxation reform to address the crown\'s debt.',
                'Popular with the poor. Catastrophic with the rich.',
                +10, -5, -10, false,
            ],
            [
                $n['TRUNK_06'], $n['TRUNK_07'], 2, null,
                'Suggest a controlled debt restructuring with the Iron Bank.',
                'Bankers have longer memories than kings.',
                0, +5, +15, true,
            ],
            [
                $n['TRUNK_06'], $n['TRUNK_07'], 3, null,
                'Quietly begin investigating where the debt money actually went.',
                'Follow the gold. The gold leaves tracks.',
                +5, +8, +8, false,
            ],

            // ── TRUNK_07 → TRUNK_08 ── The Spider's Web → The Goldcloak Conspiracy ──
            // Varys leaves a scroll. Do you trust the Master of Whisperers?
            // Order 1: trust Varys fully (power+, debt+ — he always wants something)
            // Order 2: thank warmly, then follow him (power+, small debt — smart paranoia)
            // Order 3: ignore the scroll entirely (honor+, power- — principled refusal)
            [
                $n['TRUNK_07'], $n['TRUNK_08'], 1, null,
                'Trust Varys and follow his guidance without question.',
                'The Spider\'s web catches everything — including flies who trust it.',
                -5, +10, +10, false,
            ],
            [
                $n['TRUNK_07'], $n['TRUNK_08'], 2, null,
                'Thank Varys warmly and then immediately have someone follow him.',
                'Counter-espionage. Everyone is doing it.',
                0, +8, +5, false,
            ],
            [
                $n['TRUNK_07'], $n['TRUNK_08'], 3, null,
                'Ignore the scroll entirely — Varys plants seeds that grow in directions he chooses.',
                'Paranoia is expensive. So is naivety.',
                +8, -5, 0, false,
            ],

            // ── TRUNK_08 → TRUNK_09 ── The Goldcloak Conspiracy → The Assassination Attempt ──
            // Corruption runs up through the City Watch. What do you do with the evidence?
            // Order 1: confront the commander (honor+, power+, no debt — brave)
            // Order 2: quietly corrupt in the right direction (big power+, big debt, locked)
            // Order 3: broadcast to multiple council members (honor+, power+, small debt)
            [
                $n['TRUNK_08'], $n['TRUNK_09'], 1, null,
                'Confront the Gold Cloak commander directly with your evidence.',
                'Courage. Or suicidal honesty.',
                +10, +5, 0, false,
            ],
            [
                $n['TRUNK_08'], $n['TRUNK_09'], 2, null,
                'Quietly transfer loyalist officers into key Gold Cloak positions.',
                'A slow corruption in the right direction.',
                0, +12, +15, true,
            ],
            [
                $n['TRUNK_08'], $n['TRUNK_09'], 3, null,
                'Send your findings to three different council members simultaneously.',
                'Everyone knows. No one can act alone.',
                +5, +8, +5, false,
            ],

            // ── TRUNK_09 → TRUNK_10 ── The Assassination Attempt → The King's Feast ──
            // A crossbow bolt nearly kills you. How do you respond to being a target?
            // Order 1: report loudly to the King (honor+, public armor)
            // Order 2: say nothing, double the guard (power+, private debt)
            // Order 3: investigate alone, trust no one (balanced, zero debt)
            [
                $n['TRUNK_09'], $n['TRUNK_10'], 1, null,
                'Report the assassination attempt to the King immediately and loudly.',
                'Public sympathy is a form of armor.',
                +8, 0, +5, false,
            ],
            [
                $n['TRUNK_09'], $n['TRUNK_10'], 2, null,
                'Say nothing, but double your personal guard at private expense.',
                'Silence is sometimes the safest language.',
                0, +8, +12, false,
            ],
            [
                $n['TRUNK_09'], $n['TRUNK_10'], 3, null,
                'Investigate alone, trusting no one with the information.',
                'Secrets kept alone are secrets that die with you.',
                +5, +5, 0, false,
            ],

            // ── TRUNK_10 → TRUNK_11 ── The King's Feast → The King's Illness ──
            // A political feast. Every choice is being watched and catalogued.
            // Order 1: perfectly neutral (balanced hon/pow, small debt)
            // Order 2: sit near the king (power+, honor- — proximity as weapon)
            // Order 3: arrange private meetings (power+, debt — the back-channel player)
            [
                $n['TRUNK_10'], $n['TRUNK_11'], 1, null,
                'Perform the social game perfectly — toast every faction, offend no one.',
                'Neutrality has a cost. So does choosing sides.',
                +5, +5, +8, false,
            ],
            [
                $n['TRUNK_10'], $n['TRUNK_11'], 2, null,
                'Sit near the king and demonstrate intimate access to power.',
                'Proximity to power invites attacks from power\'s enemies.',
                -5, +12, +5, false,
            ],
            [
                $n['TRUNK_10'], $n['TRUNK_11'], 3, null,
                'Use the feast to quietly arrange three private meetings for tomorrow.',
                'Politics happens between the dances.',
                0, +8, +10, false,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER III — THE BRANCHING
            // The story accelerates. Choices begin to cost more and
            // the stakes become irreversible. Debt warning thresholds
            // on these nodes are higher — the UI will start showing
            // red warnings to players approaching the cascade.
            // ══════════════════════════════════════════════════════

            // ── TRUNK_11 → TRUNK_12 ── The King's Illness → The Letter from Home ──
            // The King is gone. Power vacuum. How do you fill it?
            // Order 1: demand access to the king (power+, honor- — bold)
            // Order 2: run the council quietly (honor+, power+, small debt — competent)
            // Order 3: investigate the fever (balanced — the suspicious path)
            [
                $n['TRUNK_11'], $n['TRUNK_12'], 1, null,
                'Demand access to the King immediately — rule requires visible leadership.',
                'Boldness impresses the uncertain.',
                -5, +10, +5, false,
            ],
            [
                $n['TRUNK_11'], $n['TRUNK_12'], 2, null,
                'Begin running the council in the King\'s absence, quietly and efficiently.',
                'The effective Hand wears no crown.',
                +8, +8, +5, false,
            ],
            [
                $n['TRUNK_11'], $n['TRUNK_12'], 3, null,
                'Investigate whether the fever is genuine or manufactured.',
                'Paranoia, but the justified kind.',
                +5, +5, +8, false,
            ],

            // ── TRUNK_12 → TRUNK_13 ── The Letter from Home → The Confession in the Sept ──
            // A warning letter from home. Is it real or planted?
            // Order 1: reassure and secure the family (small gains, debt)
            // Order 2: ignore it (zero cost — dangerous complacency)
            // Order 3: send someone home to investigate (honor+, power-, small debt)
            [
                $n['TRUNK_12'], $n['TRUNK_13'], 1, null,
                'Write back with reassurance and double your family\'s security quietly.',
                'Family is armor. Family is also leverage.',
                +5, +5, +10, false,
            ],
            [
                $n['TRUNK_12'], $n['TRUNK_13'], 2, null,
                'Ignore the letter — paranoia serves the people who plant it.',
                'Ignoring a warning is itself a decision.',
                0, 0, 0, false,
            ],
            [
                $n['TRUNK_12'], $n['TRUNK_13'], 3, null,
                'Send your most trusted person home to investigate the threat directly.',
                'Protecting home costs influence here.',
                +8, -5, +5, false,
            ],

            // ── TRUNK_13 → TRUNK_14 ── The Confession in the Sept → The Council of Banners ──
            // A dying septon hands you a name. What do you do with dangerous information?
            // Order 1: pursue the name (honor+, power+, debt — commits you)
            // Order 2: burn the parchment (honor+, power-, debt- — the safe retreat)
            // Order 3: share with an ally (power+, small debt — you split the risk)
            [
                $n['TRUNK_13'], $n['TRUNK_14'], 1, null,
                'Pursue the name on the parchment — track down whoever it points to.',
                'Answers come with prices.',
                +5, +8, +8, false,
            ],
            [
                $n['TRUNK_13'], $n['TRUNK_14'], 2, null,
                'Burn the parchment and walk away from whatever it opens.',
                'Some doors should stay closed.',
                +8, -5, -5, false,
            ],
            [
                $n['TRUNK_13'], $n['TRUNK_14'], 3, null,
                'Show the parchment to one trusted ally and plan your next move together.',
                'Shared secrets are halved secrets.',
                0, +5, +5, false,
            ],

            // ── TRUNK_14 → TRUNK_15 ── The Council of Banners → The Point of No Return ──
            // The secret council. Every faction is in the room. Where do you sit?
            // Order 1: take the chair openly (honor+, power+, small debt)
            // Order 2: broker from the sidelines (honor+, power+, debt — the kingmaker)
            // Order 3: observe silently (power+, zero cost — information gathering)
            [
                $n['TRUNK_14'], $n['TRUNK_15'], 1, null,
                'Take the chair. Lead the council openly.',
                'Leadership is visible. Visibility is dangerous.',
                +5, +8, +5, false,
            ],
            [
                $n['TRUNK_14'], $n['TRUNK_15'], 2, null,
                'Decline the chair, but broker a compromise between factions.',
                'Kingmakers outlive kings.',
                +8, +5, +8, false,
            ],
            [
                $n['TRUNK_14'], $n['TRUNK_15'], 3, null,
                'Observe and say nothing — let others reveal their positions first.',
                'Silence is information.',
                0, +5, 0, false,
            ],

            // ── TRUNK_15 — THE BRANCH POINT ─────────────────────────────────────────
            // The Point of No Return. This is where the game splits.
            // House-gated choices (orders 1–9) are only visible to
            // players who have unlocked and equipped that house.
            // The commoner path (order 10) is available to everyone
            // and is the only option for unaffiliated players.
            //
            // Design note: all house choices lead to that house's
            // branch A node, which leads to branch B, which leads to
            // that house's exclusive ending. The commoner path leads
            // to COMM_A → COMM_B → one of four commoner endings.
            // ────────────────────────────────────────────────────────────────────────

            // Order 1 — House Stark (required_house_id = 1)
            [
                $n['TRUNK_15'], $n['STARK_A'], 1, 1,
                'Call upon the Northern Lords. Winter is coming, and the North remembers every debt.',
                'Only those of the wolf\'s blood understand this call.',
                +10, +5, 0, false,
            ],
            // Order 2 — House Lannister (required_house_id = 2)
            // locks_on_high_debt = true: if you've already borrowed heavily,
            // even the Lannister name won't buy you more credit
            [
                $n['TRUNK_15'], $n['LANN_A'], 2, 2,
                'Invoke the Lannister name and the weight of Casterly Rock\'s gold.',
                'Gold opens every door — for a price.',
                -5, +15, +15, true,
            ],
            // Order 3 — House Targaryen (required_house_id = 3)
            [
                $n['TRUNK_15'], $n['TARG_A'], 3, 3,
                'Send the secret word east, across the Narrow Sea.',
                'Fire and blood have long memories.',
                0, +10, +10, false,
            ],
            // Order 4 — House Baratheon (required_house_id = 4)
            [
                $n['TRUNK_15'], $n['BARA_A'], 4, 4,
                'Rally under the crowned stag and demand justice for the bloodline.',
                'Fury, when justified, is unstoppable.',
                +8, +10, +5, false,
            ],
            // Order 5 — House Tyrell (required_house_id = 5)
            [
                $n['TRUNK_15'], $n['TYR_A'], 5, 5,
                'Send a rose to Highgarden and wait for it to bloom.',
                'Patience is the most Tyrell of weapons.',
                +5, +8, +12, false,
            ],
            // Order 6 — House Martell (required_house_id = 6)
            [
                $n['TRUNK_15'], $n['MART_A'], 6, 6,
                'Reach out to Dorne with the ancient formula of respect and patience.',
                'You cannot rush the sun.',
                +8, +5, 0, false,
            ],
            // Order 7 — House Tully (required_house_id = 7)
            [
                $n['TRUNK_15'], $n['TUL_A'], 7, 7,
                'Summon the river lords under family, duty, and honour.',
                'Three words that have toppled kingdoms.',
                +10, +8, 0, false,
            ],
            // Order 8 — House Arryn (required_house_id = 8)
            [
                $n['TRUNK_15'], $n['ARR_A'], 8, 8,
                'Send a falcon to the Eyrie and invoke the old mountain law.',
                'The high places remember every oath sworn beneath them.',
                +10, +5, 0, false,
            ],
            // Order 9 — House Greyjoy (required_house_id = 9)
            // locks_on_high_debt = true: the ironborn won't answer a man drowning in debt
            [
                $n['TRUNK_15'], $n['GREY_A'], 9, 9,
                'Light a signal fire on the harbor shore — the old code the ironborn still answer.',
                'The drowned god\'s children come when called, but not without cost.',
                -5, +15, +18, true,
            ],
            // Order 10 — Commoner path (no house required)
            [
                $n['TRUNK_15'], $n['COMM_A'], 10, null,
                'Stand alone. No banner, no house, no lord. Only your own judgment.',
                'Freedom is a compass with no north.',
                +5, -5, 0, false,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER IV — HOUSE BRANCH A → B
            // Each house gets 2 choices here: one leaning toward
            // honor (order 1) and one leaning toward power (order 2).
            // Both lead to the same branch B node, but with different
            // stat profiles entering the climax scene.
            // ══════════════════════════════════════════════════════

            // ── STARK_A → STARK_B ── The Wolf's Price → The Crypts Remember ──
            [
                $n['STARK_A'], $n['STARK_B'], 1, 1,
                'Accept the Northern lords\' pledge and ride for Winterfell\'s crypts.',
                'The truth is buried in cold stone.',
                +8, +5, 0, false,
            ],
            [
                $n['STARK_A'], $n['STARK_B'], 2, 1,
                'Demand the maester\'s evidence before committing to anything.',
                'Trust but verify. Especially in the North.',
                +5, +5, +5, false,
            ],

            // ── LANN_A → LANN_B ── Gold and Leverage → The Lions' Gambit ──
            [
                $n['LANN_A'], $n['LANN_B'], 1, 2,
                'Refuse the gold — expose the chain of control it represents.',
                'Courage is expensive when lions are involved.',
                +10, -5, -5, false,
            ],
            [
                $n['LANN_A'], $n['LANN_B'], 2, 2,
                'Accept conditionally and use access to investigate the financial network.',
                'Play their game. Know their rules.',
                -5, +10, +15, true,
            ],

            // ── TARG_A → TARG_B ── The Dragon's Whisper → Fire Cannot Kill a Dragon ──
            [
                $n['TARG_A'], $n['TARG_B'], 1, 3,
                'Agree to meet the exile\'s emissary in a neutral location.',
                'Dragons do not negotiate. Their representatives do.',
                0, +8, +8, false,
            ],
            [
                $n['TARG_A'], $n['TARG_B'], 2, 3,
                'Demand proof of the bloodline before entertaining any agreement.',
                'Fire and blood, but verification first.',
                +8, +5, +5, false,
            ],

            // ── BARA_A → BARA_B ── The Stag at Bay → Storm's End Reckoning ──
            [
                $n['BARA_A'], $n['BARA_B'], 1, 4,
                'Agree to uncover and document the legitimacy proof at Storm\'s End.',
                'Truth is the only weapon that outlasts swords.',
                +10, +5, +5, false,
            ],
            [
                $n['BARA_A'], $n['BARA_B'], 2, 4,
                'Channel Baratheon fury — confront the rumor-mongers directly.',
                'Fury is persuasive. It is also exhausting.',
                +5, +10, +8, false,
            ],

            // ── TYR_A → TYR_B ── The Garden Party → The Rose and the Thorn ──
            [
                $n['TYR_A'], $n['TYR_B'], 1, 5,
                'Accept Lady Olenna\'s invitation to walk in the gardens privately.',
                'Old women who survive in politics are worth listening to.',
                +5, +8, +5, false,
            ],
            [
                $n['TYR_A'], $n['TYR_B'], 2, 5,
                'Offer the Tyrells a specific political concession as a show of good faith.',
                'Roses smell sweetest when you give them something first.',
                0, +5, +15, false,
            ],

            // ── MART_A → MART_B ── The Dornish Patience → Unbowed, Unbent, Unbroken ──
            [
                $n['MART_A'], $n['MART_B'], 1, 6,
                'Match the Dornish patience — say nothing, watch everything, for a week.',
                'The sun sets on the impatient.',
                +8, +5, 0, false,
            ],
            [
                $n['MART_A'], $n['MART_B'], 2, 6,
                'Offer Dorne something it has wanted for a generation: formal recognition.',
                'Recognition costs nothing but pride.',
                +10, 0, +5, false,
            ],

            // ── TUL_A → TUL_B ── The River's Crossing → The Riverlands' Oath ──
            [
                $n['TUL_A'], $n['TUL_B'], 1, 7,
                'Swear the River Oath on the spot, in the rain, without hesitation.',
                'Tully honors are not made in comfortable rooms.',
                +12, 0, 0, false,
            ],
            [
                $n['TUL_A'], $n['TUL_B'], 2, 7,
                'Accept the letter and request three days to prepare a worthy response.',
                'Three days is enough time to save or doom an alliance.',
                +5, +5, +5, false,
            ],

            // ── ARR_A → ARR_B ── The Eyrie's Invitation → As High as Honor ──
            [
                $n['ARR_A'], $n['ARR_B'], 1, 8,
                'Travel to the Eyrie and sit with the young lord for a full week.',
                'Patience, here, is the point.',
                +10, 0, +5, false,
            ],
            [
                $n['ARR_A'], $n['ARR_B'], 2, 8,
                'Send counsel by letter, testing whether the advisors filter it.',
                'Letters reveal who controls the reader.',
                +5, +5, +5, false,
            ],

            // ── GREY_A → GREY_B ── The Iron Price → We Do Not Sow ──
            [
                $n['GREY_A'], $n['GREY_B'], 1, 9,
                'Agree to the ironborn\'s terms and sail for Pyke at dawn.',
                'The sea is indifferent to both courage and cowardice.',
                -5, +12, +12, false,
            ],
            [
                $n['GREY_A'], $n['GREY_B'], 2, 9,
                'Counter-offer: you want the Fleet, not the men. Ships last longer.',
                'Ironborn respect directness. Occasionally.',
                0, +10, +15, true,
            ],

            // ── COMM_A → COMM_B ── No Name, No Banner → The Wanderer's Gambit ──
            [
                $n['COMM_A'], $n['COMM_B'], 1, null,
                'Approach the smallest faction first — build from the bottom of the board.',
                'The smallest pieces take the longest to notice.',
                +8, +5, 0, false,
            ],
            [
                $n['COMM_A'], $n['COMM_B'], 2, null,
                'Make a public statement of independence that both factions must respond to.',
                'The center of the board is valuable until it isn\'t.',
                +5, +5, +8, false,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER IV → CHAPTER V — BRANCH B → ENDINGS
            // Each house branch B offers two paths to its ending:
            //   Order 1: the high-honor resolution
            //   Order 2: the high-power resolution
            // Both reach the same ending node — the ending_text
            // is the same, but your final stats will differ based
            // on which path you took through the entire run.
            //
            // The commoner branch offers four exits from COMM_B,
            // one for each of the four commoner endings.
            // ══════════════════════════════════════════════════════

            // ── STARK_B → END_STARK ── The Crypts Remember → The North Remembers ──
            [
                $n['STARK_B'], $n['END_STARK'], 1, 1,
                'Reveal the proof openly in the name of justice.',
                'Honor, even when it costs everything.',
                +15, -5, 0, false,
            ],
            [
                $n['STARK_B'], $n['END_STARK'], 2, 1,
                'Use the proof as a political shield — control it without publicizing it.',
                'Power through restraint.',
                -5, +15, +10, false,
            ],

            // ── LANN_B → END_LANN ── The Lions' Gambit → The Golden Lion's Crown ──
            [
                $n['LANN_B'], $n['END_LANN'], 1, 2,
                'Expose the financial conspiracy and destroy the mechanism.',
                'Sometimes the only winning move is detonation.',
                +10, +5, -15, false,
            ],
            [
                $n['LANN_B'], $n['END_LANN'], 2, 2,
                'Take control of the mechanism instead of destroying it.',
                'A lion does not break the cage. A lion becomes the cage.',
                -10, +20, +15, true,
            ],

            // ── TARG_B → END_TARG ── Fire Cannot Kill a Dragon → Fire Reborn ──
            [
                $n['TARG_B'], $n['END_TARG'], 1, 3,
                'Swear your support openly and publicly.',
                'There is no half-measure with fire.',
                -5, +10, +10, false,
            ],
            [
                $n['TARG_B'], $n['END_TARG'], 2, 3,
                'Coordinate the return covertly — strike before the opposition can organize.',
                'The dragon rises when the sun is still set.',
                -10, +15, +12, false,
            ],

            // ── BARA_B → END_BARA ── Storm's End Reckoning → The Fury Justified ──
            [
                $n['BARA_B'], $n['END_BARA'], 1, 4,
                'Submit the proof to the Grand Maester with full ceremony.',
                'The quill mightier than the hammer, this once.',
                +15, +5, 0, false,
            ],
            [
                $n['BARA_B'], $n['END_BARA'], 2, 4,
                'Publish the proof widely before any opposition can suppress it.',
                'A truth released cannot be un-released.',
                +10, +8, +5, false,
            ],

            // ── TYR_B → END_TYR ── The Rose and the Thorn → The Rose Ascendant ──
            [
                $n['TYR_B'], $n['END_TYR'], 1, 5,
                'Accept the Tyrell offer and seal it with a public ceremony.',
                'Public joy is harder to quietly undo.',
                +5, +10, +15, false,
            ],
            [
                $n['TYR_B'], $n['END_TYR'], 2, 5,
                'Accept privately and implement the alliance quietly over months.',
                'Gardens grow slowly. They also grow completely.',
                0, +12, +8, false,
            ],

            // ── MART_B → END_MART ── Unbowed, Unbent, Unbroken → The Sunspear Accord ──
            [
                $n['MART_B'], $n['END_MART'], 1, 6,
                'Sign the Sunspear Accord with full Dornish ceremony.',
                'Ceremony matters to those who have been denied it.',
                +15, +5, 0, false,
            ],
            [
                $n['MART_B'], $n['END_MART'], 2, 6,
                'Agree and immediately begin building trade infrastructure.',
                'Peace is most durable when it is profitable.',
                +8, +8, +8, false,
            ],

            // ── TUL_B → END_TUL ── The Riverlands' Oath → The River Runs True ──
            [
                $n['TUL_B'], $n['END_TUL'], 1, 7,
                'Swear the full Tully Oath before witnesses from every major house.',
                'Words said before witnesses become stone.',
                +15, +5, 0, false,
            ],
            [
                $n['TUL_B'], $n['END_TUL'], 2, 7,
                'Swear and immediately ask what the Riverlands needs most right now.',
                'An oath with action attached is worth ten with words alone.',
                +10, +10, +5, false,
            ],

            // ── ARR_B → END_ARR ── As High as Honor → Honor Above the Clouds ──
            [
                $n['ARR_B'], $n['END_ARR'], 1, 8,
                'Guide the young lord to close the Moon Door and open the gates.',
                'The highest honor is tempering the highest power.',
                +15, -5, 0, false,
            ],
            [
                $n['ARR_B'], $n['END_ARR'], 2, 8,
                'Replace the corrupted advisors with people loyal to the young lord directly.',
                'The most lasting change is structural.',
                +8, +10, +5, false,
            ],

            // ── GREY_B → END_GREY ── We Do Not Sow → What is Dead May Never Die ──
            [
                $n['GREY_B'], $n['END_GREY'], 1, 9,
                'Seal the iron compact on the battlements with salt and stone.',
                'The sea witnesses all oaths made above it.',
                -5, +15, +10, false,
            ],
            // locks_on_high_debt = true: the ironborn won't grant raiding rights
            // to someone who can't even manage their own debts
            [
                $n['GREY_B'], $n['END_GREY'], 2, 9,
                'Offer the ironborn permanent legal recognition of their raiding rights in exchange for the Fleet.',
                'Give a kraken the deep sea and it will defend your shallows.',
                -10, +18, +20, true,
            ],

            // ── COMM_B → ENDINGS ── The Wanderer's Gambit → four possible fates ──
            // Order 1 → END_COMM_GOOD  (honor+, power+, debt-)   — the clean brokerage
            // Order 2 → END_COMM_BAD   (honor-, power-, debt+)   — the misjudgment
            // Order 3 → END_COMM_DEBT  (debt +30, locked)        — the cascade trigger
            // Order 4 → END_COMM_HONOR (honor+, power-)          — principled ruin
            [
                $n['COMM_B'], $n['END_COMM_GOOD'], 1, null,
                'Broker a compromise between both factions without joining either.',
                'The Wanderer who serves no one serves everyone.',
                +15, +5, -5, false,
            ],
            [
                $n['COMM_B'], $n['END_COMM_BAD'], 2, null,
                'Make an error in judgment that hands the advantage to the wrong side.',
                'Even good intentions navigate badly in the dark.',
                -10, -10, +10, false,
            ],
            [
                $n['COMM_B'], $n['END_COMM_DEBT'], 3, null,
                'Borrow against the future one final time to force a short-term resolution.',
                'The cascade begins here.',
                0, +5, +30, true,
            ],
            [
                $n['COMM_B'], $n['END_COMM_HONOR'], 4, null,
                'Stand firm on principle and refuse every compromise that costs your integrity.',
                'Honor, even unto ruin.',
                +20, -15, 0, false,
            ],
        ];

        // ── Insert / update ───────────────────────────────────────
        foreach ($choices as $row) {
            [
                $from, $to, $order, $reqHouse,
                $text, $hint,
                $honor, $power, $debt, $locks,
            ] = $row;

            DB::table('choices')->updateOrInsert(
                // Unique key: one display_order per source node
                ['from_node_id' => $from, 'display_order' => $order],
                [
                    'from_node_id'       => $from,
                    'to_node_id'         => $to,
                    'display_order'      => $order,
                    'required_house_id'  => $reqHouse,
                    'choice_text'        => $text,
                    'hint_text'          => $hint,
                    'honor_delta'        => $honor,
                    'power_delta'        => $power,
                    'debt_delta'         => $debt,
                    'locks_on_high_debt' => $locks,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                    'deleted_at'         => null,
                ]
            );
        }

        $total = count($choices);
        $this->command->info("ChoiceSeeder: {$total} choices seeded.");
    }
}
