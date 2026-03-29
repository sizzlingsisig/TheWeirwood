<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * NodeSeeder — The Weirwood Decision Simulator
 * ══════════════════════════════════════════════════════════════════
 * Standalone node seeder. Replaces the seedNodes() method from
 * StorySeeder. Run after houses exist:
 *   php artisan db:seed --class=NodeSeeder
 *
 * NEW IN THIS VERSION — FLAG SYSTEM NODES
 * ─────────────────────────────────────────
 * Three narrative flags thread through the story:
 *
 *   spared_thief      Set in Ch I (TRUNK_02 choice).
 *                     Unlocks a mercy-based shortcut in Ch IV.
 *                     Signals: player values mercy over expedience.
 *
 *   killed_thief      Set in Ch I (TRUNK_02 choice — the other path).
 *                     Blocks the mercy shortcut. Enables a ruthlessness
 *                     bonus in Ch III. Forbidden on honor-gated choices.
 *
 *   found_secret_letter  Set in Ch I (TRUNK_03 choice — secret investigation).
 *                        Unlocks additional intelligence in Ch II (TRUNK_07)
 *                        and a critical advantage in Ch III (TRUNK_13).
 *
 * FLAG-CONSEQUENCE NODES (new, IDs 49–52):
 *   THIEF_MERCY   (49) — only reachable if spared_thief is set
 *   THIEF_BLOOD   (50) — only reachable if killed_thief is set
 *   LETTER_REVEAL (51) — only reachable if found_secret_letter is set
 *   LETTER_MISS   (52) — only reachable if found_secret_letter is NOT set
 *
 * Both THIEF_MERCY and THIEF_BLOOD ultimately route back to TRUNK_15
 * (The Point of No Return) — they are 1-node detours that apply
 * stat adjustments and narrative context before the branch point.
 * LETTER_REVEAL and LETTER_MISS are inserted between TRUNK_12 and
 * TRUNK_13 as a consequence beat.
 *
 * ──────────────────────────────────────────────────────────────────
 * NODE ID REFERENCE (full map)
 * ──────────────────────────────────────────────────────────────────
 * Trunk        1–15
 * STARK_A/B    16, 17    LANN_A/B     18, 19    TARG_A/B     20, 21
 * BARA_A/B     22, 23    TYR_A/B      24, 25    MART_A/B     26, 27
 * TUL_A/B      28, 29    ARR_A/B      30, 31    GREY_A/B     32, 33
 * COMM_A/B     34, 35
 * END_COMM_GOOD 36   END_COMM_BAD 37   END_COMM_DEBT 38   END_COMM_HONOR 39
 * END_STARK 40  END_LANN 41  END_TARG 42  END_BARA 43  END_TYR  44
 * END_MART  45  END_TUL  46  END_ARR  47  END_GREY  48
 * THIEF_MERCY 49   THIEF_BLOOD 50   LETTER_REVEAL 51   LETTER_MISS 52
 */
class NodesSeeder extends Seeder
{
    private const N = [
        'TRUNK_01' => 1, 'TRUNK_02' => 2, 'TRUNK_03' => 3,
        'TRUNK_04' => 4, 'TRUNK_05' => 5, 'TRUNK_06' => 6,
        'TRUNK_07' => 7, 'TRUNK_08' => 8, 'TRUNK_09' => 9,
        'TRUNK_10' => 10, 'TRUNK_11' => 11, 'TRUNK_12' => 12,
        'TRUNK_13' => 13, 'TRUNK_14' => 14, 'TRUNK_15' => 15,

        'STARK_A' => 16, 'STARK_B' => 17,
        'LANN_A' => 18, 'LANN_B' => 19,
        'TARG_A' => 20, 'TARG_B' => 21,
        'BARA_A' => 22, 'BARA_B' => 23,
        'TYR_A' => 24, 'TYR_B' => 25,
        'MART_A' => 26, 'MART_B' => 27,
        'TUL_A' => 28, 'TUL_B' => 29,
        'ARR_A' => 30, 'ARR_B' => 31,
        'GREY_A' => 32, 'GREY_B' => 33,
        'COMM_A' => 34, 'COMM_B' => 35,

        'END_COMM_GOOD' => 36, 'END_COMM_BAD' => 37,
        'END_COMM_DEBT' => 38, 'END_COMM_HONOR' => 39,
        'END_STARK' => 40, 'END_LANN' => 41,
        'END_TARG' => 42, 'END_BARA' => 43,
        'END_TYR' => 44, 'END_MART' => 45,
        'END_TUL' => 46, 'END_ARR' => 47,
        'END_GREY' => 48,

        // Flag-consequence nodes (new)
        'THIEF_MERCY' => 49,
        'THIEF_BLOOD' => 50,
        'LETTER_REVEAL' => 51,
        'LETTER_MISS' => 52,
    ];

    public function run(): void
    {
        $now = Carbon::now();
        $n = self::N;

        // Row format:
        // [id, node_code, chapter_label, title, narrative_text,
        //  debt_warning_text, debt_warning_threshold, is_ending]

        $nodes = [

            // ══════════════════════════════════════════════════════
            // CHAPTER I — PROLOGUE  (TRUNK_01–05)
            // Flag seeds happen here:
            //   TRUNK_02 choices → spared_thief OR killed_thief
            //   TRUNK_03 choices → found_secret_letter (optional)
            // ══════════════════════════════════════════════════════

            [
                $n['TRUNK_01'], 'TRUNK_01', 'Chapter I: Prologue',
                'The Raven Arrives',
                'A black-waxed scroll drops onto the rushes of your modest hall. The seal is broken — a crown pressed into wax the colour of dried blood. The message is brief: "The Hand is dead. The King requires counsel. Come to King\'s Landing." Silence falls over your table. This is not an invitation. It is a leash.',
                null, 40, false,
            ],
            [
                $n['TRUNK_02'], 'TRUNK_02', 'Chapter I: Prologue',
                'The Road South',
                'Your column leaves at dawn, banners furled against the mist. Old Maester Edwyn rides beside you, his chains clinking a worried rhythm. "They say three Hands have died in as many years," he murmurs. "One from fever, one from grief, and one they simply... stopped talking about." The King\'s Road stretches south like a wound in the earth. Near the Crossroads, your outriders drag a thin boy from a ditch — caught stealing a horse from a merchant\'s camp. The merchant demands a hand. The boy says nothing. He is perhaps ten years old.',
                null, 40, false,
            ],
            [
                $n['TRUNK_03'], 'TRUNK_03', 'Chapter I: Prologue',
                'The Inn at the Crossroads',
                'Three cloaked riders share your inn\'s common room, arriving separately yet pretending not to know each other. The innkeeper sweats despite the cold. One rider slides a velvet pouch across a table — coins inside ring silver, far too many for any honest errand. They are watching you. Your servants have been in the stables long enough to overhear things. There may be more to this meeting than coin.',
                null, 40, false,
            ],
            [
                $n['TRUNK_04'], 'TRUNK_04', 'Chapter I: Prologue',
                'The Gates of King\'s Landing',
                'The city assaults every sense at once: a thousand cook-fires, the cry of gulls over the Blackwater, the damp rot of the harbor district. A Gold Cloak captain bars your way. "Business?" he asks, though his eyes say he already knows the answer — and that the answer will cost you.',
                null, 40, false,
            ],
            [
                $n['TRUNK_05'], 'TRUNK_05', 'Chapter I: Prologue',
                'The Red Keep',
                'You are ushered through corridors of red stone and shadows that move on their own. At last, the throne room opens before you: five hundred swords fused into a single monstrosity. The King sits atop it, bored and slightly drunk. He smiles. It is not a kind smile.',
                null, 40, false,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER II — THE RISING TENSION  (TRUNK_06–10)
            // found_secret_letter pays off at TRUNK_07 (extra choice).
            // ══════════════════════════════════════════════════════

            [
                $n['TRUNK_06'], 'TRUNK_06', 'Chapter II: The Rising Tension',
                'The Small Council',
                'The Small Council chamber smells of old wine and older grudges. Six pairs of eyes measure you the moment you enter. The Master of Coin taps a finger on a ledger thick as a gravestone. "The crown is four million gold dragons in debt," he announces without preamble. Someone, somewhere, is owed a reckoning.',
                null, 50, false, null,
            ],
            [
                $n['TRUNK_07'], 'TRUNK_07', 'Chapter II: The Rising Tension',
                'The Spider\'s Web',
                'Lord Varys appears in your chambers without knocking, without candlelight, and without any apparent reason for being there at all. "I thought you should know," he whispers, setting a small scroll on your pillow, "that someone has been asking questions about you. Very specific questions." He is gone before you can reply. If you found the letter at the inn — the one with the broken seal and the wrong house sigil — you already know who sent him.',
                null, 50, false, null,
            ],
            [
                $n['TRUNK_08'], 'TRUNK_08', 'Chapter II: The Rising Tension',
                'The Goldcloak Conspiracy',
                'Three prisons, two dungeons, one unmarked grave. Your investigation into the Gold Cloaks uncovers a pattern of bribes flowing from the port district up through the City Watch and into the lower levels of the Keep itself. The trail ends at a door with no nameplate. Someone is funding a private army within the city walls.',
                'The interest on borrowed loyalty always comes due.',
                55, false, null,
            ],
            [
                $n['TRUNK_09'], 'TRUNK_09', 'Chapter II: The Rising Tension',
                'The Assassination Attempt',
                'The crossbow bolt takes your candle instead of your throat — close enough to leave a burn on your cheek. In the dark you hear boots retreating across cobblestones. They were professionals. They were paid. And someone in the Keep knew your evening route.',
                null, 50, false, null,
            ],
            [
                $n['TRUNK_10'], 'TRUNK_10', 'Chapter II: The Rising Tension',
                'The King\'s Feast',
                'A feast is declared in honor of nothing in particular — the King\'s way of asserting that he can afford excess. Every great lord in the city attends. Alliances are made in whispered toasts. Enemies are identified by where they choose to sit. You have a seat of honor, which means everyone is watching what you eat, drink, and say.',
                null, 50, false, null,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER III — THE BRANCHING  (TRUNK_11–15)
            // TRUNK_12 now forks through LETTER_REVEAL / LETTER_MISS
            // before reaching TRUNK_13. The flag consequence nodes
            // (IDs 51–52) sit between TRUNK_12 and TRUNK_13 in the DAG.
            // TRUNK_13 (the Confession) now has a found_secret_letter
            // advantage choice that only appears with the flag set.
            // killed_thief pays off at TRUNK_11 (ruthlessness bonus).
            // spared_thief pays off at TRUNK_14 (mercy shortcut).
            // ══════════════════════════════════════════════════════

            [
                $n['TRUNK_11'], 'TRUNK_11', 'Chapter III: The Branching',
                'The King\'s Illness',
                'The maesters speak of a fever. The gossips speak of poison. The King has not appeared in three days, and in his absence the Red Keep has fractured into a dozen competing courts, each convinced it will inherit what comes next. You stand at the center of the storm. Those who have learned to act without hesitation — to cut what must be cut and ask no questions after — find themselves ahead of the scramble.',
                null, 60, false, null,
            ],
            [
                $n['TRUNK_12'], 'TRUNK_12', 'Chapter III: The Branching',
                'The Letter from Home',
                'A raven arrives bearing your house\'s seal — or the seal of the Wanderer\'s guild, if you ride for no lord. The message is brief and written in a hand that trembles: "They know you are here. They know what you know. Do not trust the Lannister gold. Do not trust the northern silence. Come home or do not come home at all." The letter raises a question you have been avoiding: what, exactly, do you know?',
                null, 60, false, null,
            ],
            [
                $n['TRUNK_13'], 'TRUNK_13', 'Chapter III: The Branching',
                'The Confession in the Sept',
                'In the Sept of Baelor, an old septon presses a folded parchment into your hand and dies three steps later — no wound, no struggle, simply done. The parchment contains a single name and a location. Whether this is a gift, a trap, or both, you cannot yet say. If you already know the name from the letter at the inn — if you\'ve carried it quietly for weeks — the confirmation lands differently. Not as a revelation. As a verdict.',
                'The debts of the gods are paid in blood and years.',
                65, false, null,
            ],
            [
                $n['TRUNK_14'], 'TRUNK_14', 'Chapter III: The Branching',
                'The Council of Banners',
                'Every great house that has a presence in King\'s Landing sends a representative to a secret meeting beneath the Street of Steel. They all want the same thing: survival. But survival means something different to each of them. The chair at the head of the table is yours, if you want it. The moment you sit, you choose a side. There are those here who remember the boy on the road — who heard what you did, and have drawn their own conclusions about the kind of person you are.',
                'A chair at this table costs more than gold.',
                65, false, null,
            ],
            [
                $n['TRUNK_15'], 'TRUNK_15', 'Chapter III: The Branching',
                'The Point of No Return',
                'You have seen the ledgers, survived the assassins, and read the dying man\'s note. The picture is complete and it is ugly. The city will burn — the question is who holds the torch and who controls the ashes. You cannot leave. You cannot stay neutral. The decision you make in the next hour will define the rest of your life.',
                'Every debt compounds. Every choice narrows.',
                70, false, null,
            ],

            // ══════════════════════════════════════════════════════
            // FLAG CONSEQUENCE NODES (new, IDs 49–52)
            //
            // These are 1-node narrative beats that sit between
            // existing trunk nodes. They apply no mechanical changes
            // themselves — the choices leading INTO them and OUT OF
            // them carry the stat deltas. Their purpose is to give
            // the player a moment of acknowledgement that their
            // earlier decision mattered before the story continues.
            // ══════════════════════════════════════════════════════

            // THIEF_MERCY (49) — reached if spared_thief flag is set
            // Inserted between TRUNK_14 and TRUNK_15
            // The boy the player spared appears again, unexpectedly useful.
            [
                $n['THIEF_MERCY'], 'THIEF_MERCY', 'Chapter III: The Branching',
                'The Debt Repaid',
                'A shadow slips through the door of your anteroom as the council disperses. The thin boy from the Crossroads road — older now, harder, wearing the livery of a minor lord\'s household — sets a sealed document on your desk without a word. His eyes say: we are even. The document is a list of names. People who have been paid to testify against you. You recognise three of them from the feast last month. He is gone before you can speak. Some debts are paid in coin. Some are paid in names.',
                null, 60, false, null,
            ],

            // THIEF_BLOOD (50) — reached if killed_thief flag is set
            // Inserted between TRUNK_14 and TRUNK_15
            // A witness to the execution has found the council.
            [
                $n['THIEF_BLOOD'], 'THIEF_BLOOD', 'Chapter III: The Branching',
                'The Merchant\'s Testimony',
                'The merchant from the Crossroads has made it to King\'s Landing. He has been speaking to the wrong people — a minor lord\'s steward, one of the Master of Whispers\' lesser birds, a septa with a reputation for memory. He is not dangerous yet. But he is building toward something, and the story he is telling is not flattering. The boy had a name, it turns out. Someone in this city knew it.',
                'Old sins cast long shadows on new roads.',
                65, false, null,
            ],

            // LETTER_REVEAL (51) — reached if found_secret_letter is set
            // Inserted between TRUNK_12 and TRUNK_13
            // The player already knows the name on the dying septon's parchment.
            [
                $n['LETTER_REVEAL'], 'LETTER_REVEAL', 'Chapter III: The Branching',
                'The Name You Already Knew',
                'You have been carrying it since the inn at the Crossroads — the broken-sealed letter, the wrong sigil, the name written in a hand that was trying to be careful and failing. You knew what the dying septon was going to give you before he pressed it into your palm. You have had weeks to prepare. The question is not what the parchment says. The question is what you have done with the time you had.',
                null, 60, false, null,
            ],

            // LETTER_MISS (52) — reached if found_secret_letter is NOT set
            // Inserted between TRUNK_12 and TRUNK_13
            // The player is caught off-guard by the revelation.
            [
                $n['LETTER_MISS'], 'LETTER_MISS', 'Chapter III: The Branching',
                'The Name You Did Not Know',
                'The name on the parchment means nothing to you. You turn it over. You read it again. The septon is already dead and cannot explain. Whatever context the name required — whatever thread it attached to — you did not pick it up when it was offered. The name is a door. You are standing in front of it without a key, while somewhere behind you, the person who sent the septon is already moving.',
                'Every secret has an expiry. This one expired before you found it.',
                65, false, null,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER IV — HOUSE BRANCHES (unchanged nodes)
            // ══════════════════════════════════════════════════════

            [
                $n['STARK_A'], 'STARK_A', 'Chapter IV: The House Quests',
                'The Wolf\'s Price',
                'A Grey Wind howls through your dreams. When you wake, Winterfell\'s maester stands in your doorway having ridden hard for a fortnight. The Northern lords are moving — not to rebel, but to pledge. Word has traveled that you stand for honour above convenience, and in the North, that is the only currency that matters.',
                null, 60, false, 1,
            ],
            [
                $n['STARK_B'], 'STARK_B', 'Chapter IV: The House Quests',
                'The Crypts Remember',
                'You descend into the crypts beneath Winterfell by torchlight, surrounded by the stone faces of dead kings. The maester reveals the truth buried here: proof of a blood claim that would shatter the current order. You can use it, bury it, or burn it. All three paths lead somewhere terrible and somewhere right.',
                null, 65, false, 1,
            ],
            [
                $n['LANN_A'], 'LANN_A', 'Chapter IV: The House Quests',
                'Gold and Leverage',
                'A Lannister man arrives with a chest of gold and a smile thinner than the gold leaf on the coins. He does not ask. He informs. The Lannisters have already bought every counterweight to your influence in the city. The offer is simple: be purchased, or be removed. The gold smells like a prison.',
                'Lannister gold always comes with chains attached.',
                70, false, 2,
            ],
            [
                $n['LANN_B'], 'LANN_B', 'Chapter IV: The House Quests',
                'The Lions\' Gambit',
                'Deep in Casterly Rock\'s financial records — obtained at considerable personal risk — you find the mechanism: the Lannisters have been funding both sides of every conflict for a generation, profiting from the blood of others. You now hold proof of the greatest financial conspiracy in Westerosi history. What you do with it writes the next hundred years.',
                null, 70, false, 2,
            ],
            [
                $n['TARG_A'], 'TARG_A', 'Chapter IV: The House Quests',
                'The Dragon\'s Whisper',
                'A ship from Essos anchors in the harbor at night, flying no sigil. Its passenger is cloaked and dangerous and carries a message sealed with three dragon heads. The exiled blood of Old Valyria has not forgotten the Seven Kingdoms — and the Seven Kingdoms\' sins have a long memory of their own.',
                null, 65, false, 3,
            ],
            [
                $n['TARG_B'], 'TARG_B', 'Chapter IV: The House Quests',
                'Fire Cannot Kill a Dragon',
                'The choice laid before you is ancient and absolute: swear to the dragon\'s cause and watch a world remade in fire, or stand against the tide and perhaps be the stone that breaks it. The exile\'s eyes hold something more dangerous than ambition. They hold certainty.',
                'Fire purifies. Fire also destroys everything.',
                70, false, 3,
            ],
            [
                $n['BARA_A'], 'BARA_A', 'Chapter IV: The House Quests',
                'The Stag at Bay',
                'Lord Baratheon\'s rage has become legend: three chairs broken in a single council, a herald struck for hesitating, a war-hammer dented against a wall. But his fury is not without cause — someone has been poisoning the legitimacy of his bloodline, one whispered rumour at a time. He needs an ally with a quieter kind of power.',
                null, 60, false, 4,
            ],
            [
                $n['BARA_B'], 'BARA_B', 'Chapter IV: The House Quests',
                'Storm\'s End Reckoning',
                'Storm\'s End at last — the castle that withstood a year of siege by refusing to fall down. The proof you carry will either restore the Baratheon line\'s legitimacy or shatter it forever. There are sellswords in the yard and ravens ready to fly. The next ten minutes will decide which.',
                null, 65, false, 4,
            ],
            [
                $n['TYR_A'], 'TYR_A', 'Chapter IV: The House Quests',
                'The Garden Party',
                'Highgarden\'s pavilion is draped in roses and deception in equal measure. Lady Olenna pours your wine herself, which means it is definitely not poisoned — she would never waste a good method on someone she could use. "You are cleverer than you look," she tells you. "Most people who come here are not. Sit. Eat. Tell me everything."',
                null, 55, false, 5,
            ],
            [
                $n['TYR_B'], 'TYR_B', 'Chapter IV: The House Quests',
                'The Rose and the Thorn',
                'The Tyrells\' offer is extraordinary: grain enough to feed the city through winter, gold enough to clear the crown\'s debt, and soldiers enough to hold the gates. The price is a marriage alliance that will make Highgarden the true power behind every throne for a generation. Roses grow beautiful. Roses also have thorns.',
                'Borrowed grain must one day be repaid in blood or gold.',
                65, false, 5,
            ],
            [
                $n['MART_A'], 'MART_A', 'Chapter IV: The House Quests',
                'The Dornish Patience',
                'The Martell representative has been waiting in King\'s Landing for six months, eating terrible food and saying nothing, which is precisely the most terrifying thing they could do. They have been watching. They have been counting. When they finally speak to you privately, you understand that Dorne has already won — they are simply waiting for everyone else to realize it.',
                null, 60, false, 6,
            ],
            [
                $n['MART_B'], 'MART_B', 'Chapter IV: The House Quests',
                'Unbowed, Unbent, Unbroken',
                'The sun-spear glints in the Dornish envoy\'s hand as they lay a choice before you: accept Dorne\'s terms and gain an ally who has never once bent to a conqueror, or refuse and face the south\'s ancient, patient, absolute enmity. Sand, sun, and poison have outlasted every empire that tried to end them.',
                null, 65, false, 6,
            ],
            [
                $n['TUL_A'], 'TUL_A', 'Chapter IV: The House Quests',
                'The River\'s Crossing',
                'The Tully delegation arrives soaked from a ford that should have been dry — which means someone diverted the Tumblestone, which means someone with considerable resources is trying to delay this meeting. Lord Tully\'s son wrings water from his cloak and hands you a sealed letter anyway. Family first. Duty second. Honour always.',
                null, 55, false, 7,
            ],
            [
                $n['TUL_B'], 'TUL_B', 'Chapter IV: The House Quests',
                'The Riverlands\' Oath',
                'In the great hall of Riverrun, surrounded by fish-carved stone and the sound of two rivers meeting, you are asked to swear. The oath is simple. The weight of it is not. To swear by Tully is to swear by family, duty, and honour — three words that have started more wars than any army in history.',
                null, 60, false, 7,
            ],
            [
                $n['ARR_A'], 'ARR_A', 'Chapter IV: The House Quests',
                'The Eyrie\'s Invitation',
                'The invitation arrives via falcon, literally — a small scroll tied to the leg of a bird that could only have come from the Eyrie\'s legendary aerie. The Vale has been silent for too long, the letter implies. Its new lord is young, uncertain, and surrounded by advisors who profit from that uncertainty. They need a voice from outside.',
                null, 55, false, 8,
            ],
            [
                $n['ARR_B'], 'ARR_B', 'Chapter IV: The House Quests',
                'As High as Honor',
                'The Moon Door stands open at your back — a reminder of what the Eyrie\'s justice looks like when patience ends. The young Lord Robin watches you with his mother\'s fearful eyes and his father\'s hungry ones. You can guide this house toward the sky or watch it fall through its own floor. Honor, here, is not a virtue. It is a weapon.',
                null, 65, false, 8,
            ],
            [
                $n['GREY_A'], 'GREY_A', 'Chapter IV: The House Quests',
                'The Iron Price',
                'A longship sits in the harbor with a kraken carved into its prow and saltwater still dripping from its oars — it arrived in the night without the harbor watch noticing, which is the point. The ironborn do not ask. They take. But the Greyjoy captain who steps off has come to offer a trade, and ironborn do not trade unless the value is something extraordinary.',
                'What is dead may never die — but debt is harder to drown.',
                70, false, 9,
            ],
            [
                $n['GREY_B'], 'GREY_B', 'Chapter IV: The House Quests',
                'We Do Not Sow',
                'Pyke in a storm is one of the most hostile places on earth — the castle seems to be falling into the sea and has been for centuries, held together by stubbornness and salt. The Greyjoy lord meets you on the battlements above the crashing waves. "We do not sow," he says. "We reap. The question is whether you are the crop or the scythe."',
                null, 70, false, 9,
            ],
            [
                $n['COMM_A'], 'COMM_A', 'Chapter IV: The House Quests',
                'No Name, No Banner',
                'Without a great house at your back, you are a blade with no hilt — useful, dangerous, easily dropped. The city\'s smallfolk know you as fair. The hedge knights respect your word. It is not nothing. In a world of lions and dragons and wolves, the unaffiliated sometimes slip through the gaps that the great beasts cannot navigate.',
                null, 60, false, null,
            ],
            [
                $n['COMM_B'], 'COMM_B', 'Chapter IV: The House Quests',
                'The Wanderer\'s Gambit',
                'You have no banners, no ancestral seat, no army. What you have is information, reputation, and the priceless asset of not being clearly anyone\'s enemy. The two great factions who have been circling each other for months both approach you on the same day. The Wanderer who serves no one may be the only person in King\'s Landing who can end this without blood.',
                'Freedom from allegiance means no one fights for you when it falls apart.',
                65, false, null,
            ],

            // ══════════════════════════════════════════════════════
            // CHAPTER V — ENDINGS (unchanged)
            // ══════════════════════════════════════════════════════

            [
                $n['END_COMM_GOOD'], 'END_COMM_GOOD', 'Chapter V: The Resolution',
                'The Wanderer\'s Peace',
                'No songs will be written about you. No statues raised. You will not found a dynasty or be remembered by a maester three hundred years hence. But the city is quieter than it was, the smallfolk a little safer, and one small thread of justice woven into a tapestry of chaos. Some lives end well without ending loudly.',
                null, 40, true, null,
            ],
            [
                $n['END_COMM_BAD'], 'END_COMM_BAD', 'Chapter V: The Resolution',
                'Consumed by the Game',
                'The game swallowed you. Not in fire, not in glory — in paperwork and politics and the grinding weight of things you could not change. When the new lord\'s men escort you from King\'s Landing with nothing but a horse and a warning, you ride north and do not look back. You were not built for this. Perhaps that is not entirely a shame.',
                null, 40, true, null,
            ],
            [
                $n['END_COMM_DEBT'], 'END_COMM_DEBT', 'Chapter V: The Resolution',
                'Collapse of the Wanderer',
                'The ledger comes due all at once. Debts financial, political, and personal converge in a single catastrophic week. The smallfolk you tried to protect cannot save you. The lords you refused to serve will not. You leave King\'s Landing at night, owing everything to everyone, carrying nothing but your name — and that too, perhaps, is borrowed.',
                'When the cascade begins, even the cascade is in debt.',
                80, true, null,
            ],
            [
                $n['END_COMM_HONOR'], 'END_COMM_HONOR', 'Chapter V: The Resolution',
                'Forsaken',
                'Honor without power is a beautiful coat in a blizzard — it tells everyone exactly who you are right up until you freeze to death. You made every right choice by every honest measure, and it destroyed you anyway. They call you a fool in King\'s Landing. In the provinces, some call you a saint. Neither keeps you warm.',
                null, 40, true, null,
            ],
            [
                $n['END_STARK'], 'END_STARK', 'Chapter V: The Resolution',
                'The North Remembers',
                'Winter came, as it always does, and when it did the North was ready. Your choices secured the ancient pact between Winterfell and the crown — not in gold or swords, but in the one currency the North has traded in for eight thousand years: trust. The direwolf banner rises over the King\'s Gate, and for once, the south shudders in a way that feels like respect.',
                null, 40, true, 1,
            ],
            [
                $n['END_LANN'], 'END_LANN', 'Chapter V: The Resolution',
                'The Golden Lion\'s Crown',
                'A Lannister always pays their debts — and now the debts of the entire realm are denominated in Lannister gold. The master stroke is complete: every lord, every guild, every mercenary company ultimately traces its loyalty up a chain that ends in Casterly Rock. The lion did not conquer the throne. The lion became the foundation it rests upon.',
                null, 40, true, 2,
            ],
            [
                $n['END_TARG'], 'END_TARG', 'Chapter V: The Resolution',
                'Fire Reborn',
                'The dragons were never truly gone. Neither was the bloodline that rode them. Your support lit the fuse of a return that historians will argue about for centuries — liberation or reconquest, purification or burning. The answer, as with all things Valyrian, is probably both. The Iron Throne melts under dragonfire. Something older rises in its place.',
                null, 40, true, 3,
            ],
            [
                $n['END_BARA'], 'END_BARA', 'Chapter V: The Resolution',
                'The Fury Justified',
                'The stag endured. The truth of the bloodline, made unimpeachable, silenced the whispers that had circled Baratheon legitimacy for a generation. Robert\'s line stands — not by conquest this time, but by the harder, stranger magic of documented evidence and political will. The fury was always justified. Now the realm knows it.',
                null, 40, true, 4,
            ],
            [
                $n['END_TYR'], 'END_TYR', 'Chapter V: The Resolution',
                'The Rose Ascendant',
                'Highgarden\'s grain fed the city through the longest winter anyone under forty had ever seen. Highgarden\'s gold cleared the debt. Highgarden\'s soldiers held the walls. When the crisis ended, the Tyrells did not ask for the throne — they simply owned the infrastructure of everything that supported it. Power, it turns out, grows better in gardens.',
                null, 40, true, 5,
            ],
            [
                $n['END_MART'], 'END_MART', 'Chapter V: The Resolution',
                'The Sunspear Accord',
                'Dorne has never been conquered. It simply waits. Your accord with the Martells was the first honest treaty between the south and the Iron Throne in living memory — not because the dragons burned the resistance away, but because someone finally asked Dorne what it actually wanted. They wanted to be left alone. That is, historically, the most expensive thing in the world to provide.',
                null, 40, true, 6,
            ],
            [
                $n['END_TUL'], 'END_TUL', 'Chapter V: The Resolution',
                'The River Runs True',
                'The Riverlands have been the battlefield of every war for a thousand years because they lie between everyone and everywhere. Your oath to House Tully transformed the Riverlands from a wound in the realm\'s center into a bridge. The silver trout swims upstream against the current, as it always has. Family, duty, honour — three words that won more than any sword.',
                null, 40, true, 7,
            ],
            [
                $n['END_ARR'], 'END_ARR', 'Chapter V: The Resolution',
                'Honor Above the Clouds',
                'The Vale of Arryn closed its gates to the war and opened them only when the war was over — a strategy so cold and so correct that even its enemies had to admire the geometry of it. You gave the young lord the counsel his father never had: that height is only an advantage if you eventually descend. The falcon soars. Then it stoops.',
                null, 40, true, 8,
            ],
            [
                $n['END_GREY'], 'END_GREY', 'Chapter V: The Resolution',
                'What is Dead May Never Die',
                'The Iron Fleet appeared in the harbor at dawn, forty ships that had materialized from fog and saltwater and old fury. The Greyjoy compact you brokered was laughed at in every castle in Westeros — right up until the moment it was the only reason the city still had a harbor. The kraken does not ask. It simply arrives. You made sure it arrived for you.',
                null, 40, true, 9,
            ],
        ];

        foreach ($nodes as $row) {
            DB::table('nodes')->updateOrInsert(['id' => $row[0]], [
                'id' => $row[0],
                'node_code' => $row[1],
                'chapter_label' => $row[2],
                'title' => $row[3],
                'narrative_text' => $row[4],
                'debt_warning_text' => $row[5],
                'debt_warning_threshold' => $row[6],
                'is_ending' => $row[7],
                'art_image_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]);
        }

        $total = count($nodes);
        $this->command->info("NodeSeeder: {$total} nodes seeded (59 total: 55 original + 4 flag-consequence nodes).");
    }
}
