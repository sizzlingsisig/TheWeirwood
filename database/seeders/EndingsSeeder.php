<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EndingsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $n = NodeIds::$map;

        // [node_id, verdict_label, ending_type, ending_text, required_house_id, unlocks_house_id]
        $endings = [
            // Commoner Endings (4)
            [
                $n['END_COMM_GOOD'],
                'A Life Quietly Well-Lived',
                'neutral',
                'History will not remember your name. But in the alleys and marketplaces where the smallfolk trade stories, a tale persists of a wanderer who came to the city with nothing, refused to be bought, and left with honor intact. It is a quiet legacy. It is enough.',
                null, null,
            ],
            [
                $n['END_COMM_BAD'],
                'Exiled from the Game',
                'neutral',
                'You survived, which is more than can be said for the last three Hands of the King. The gold cloak\'s escort rides with you to the city gate, and at the boundary stone, they turn back without a word. You ride on alone. Somewhere behind you, the city continues to burn in its slow, permanent way.',
                null, null,
            ],
            [
                $n['END_COMM_DEBT'],
                'Broken by the Cascade',
                'debt',
                'The debts compounded faster than you could pay them. Political debt, financial debt, the debt of promises made in the dark and called due in the daylight. The cascade that began with a single borrowed favor ends with everything gone. You are not dead. Sometimes that is the crueler outcome.',
                null, null,
            ],
            [
                $n['END_COMM_HONOR'],
                'The Saint No One Mourns',
                'honor',
                'You chose honor at every fork and arrived, honorably, at ruin. The system was not designed for honest players. Posterity will call you admirable. Posterity, however, is not here to help you rebuild.',
                null, null,
            ],

            // House Endings (9) — each unlocks its own house
            [
                $n['END_STARK'],
                'Warden of the True North',
                'honor',
                'The direwolf banner flies over a city that respects it, finally, out of something more than fear. You did not play the game of thrones — you played the older game, the one about what a person does when the winter comes and no one is watching. Winter came. You did not flinch. The North remembers, and now, so does the realm.',
                1, 1,
            ],
            [
                $n['END_LANN'],
                'The Architect of a Golden Age',
                'power',
                'They will write that the realm was conquered by a lion. The truth, which only you and a handful of dead men know, is that it was purchased — ledger entry by ledger entry, debt by debt, until the entire structure of Westeros bore the Lannister watermark. Gold is patient. Gold is permanent. Gold won.',
                2, 2,
            ],
            [
                $n['END_TARG'],
                'Herald of the Returning Dragon',
                'war',
                'You chose the fire and the fire was real. The dragon\'s return will be called a conquest by those who lost and a liberation by those who lived. The distinction matters less than you expected. What matters is that the blood of the dragon, which everyone had assumed extinguished, burns brighter for having been denied so long.',
                3, 3,
            ],
            [
                $n['END_BARA'],
                'Defender of the Stag\'s Line',
                'honor',
                'The rumors are silenced. The proof is entered into the grand maester\'s registry in triplicate. House Baratheon\'s claim, legitimate from the beginning, is now unassailable by law, by lineage, and by the weight of documented history. The fury was always right. Sometimes being right is sufficient.',
                4, 4,
            ],
            [
                $n['END_TYR'],
                'Architect of the Flowering Court',
                'power',
                'Highgarden does not need the throne. It needs only to be indispensable to whoever sits on it, and that, you have arranged with characteristic Tyrell elegance. The rose is not the most dangerous flower in the garden. It is merely the most visible. The roots go deeper than anyone suspects.',
                5, 5,
            ],
            [
                $n['END_MART'],
                'Voice of the Unbroken',
                'honor',
                'The Sunspear Accord is the first honest peace the realm has seen in forty years — not a surrender, not a ceasefire, but a genuine acknowledgment that Dorne has always been different and always will be, and that this is not a problem requiring a military solution. You gave Dorne what it always deserved: to be left sovereign and respected.',
                6, 6,
            ],
            [
                $n['END_TUL'],
                'Bridge of the Realm',
                'honor',
                'The Riverlands stop burning. The trout banner flies over fords that armies have crossed in anger for generations, and this time, they cross in trade. You swore to family, duty, and honor in that order, and discovered that when all three point the same direction, even a river runs upstream.',
                7, 7,
            ],
            [
                $n['END_ARR'],
                'The High Justiciar',
                'honor',
                'The Eyrie\'s justice has always fallen from a great height. You helped a young lord understand that justice ought also to be tempered with mercy, and that the Moon Door is a last resort rather than a first one. The Vale closes again, but this time, its gates will open for the right reasons.',
                8, 8,
            ],
            [
                $n['END_GREY'],
                'Breaker of Harbors',
                'war',
                'The Iron Fleet is worth a hundred thousand soldiers when it appears where no one expects it. Your compact with the ironborn was mad, impractical, and the decisive factor in everything that followed. They do not sow. They reaped the harvest you planted for them, and you reaped yours. The sea remembers no debt. The sea only remembers the tide.',
                9, 9,
            ],
        ];

        foreach ($endings as [$nodeId, $verdict, $type, $text, $reqHouse, $unlocksHouse]) {
            DB::table('endings')->updateOrInsert(['node_id' => $nodeId], [
                'node_id'           => $nodeId,
                'verdict_label'     => $verdict,
                'ending_type'       => $type,
                'ending_text'       => $text,
                'required_house_id' => $reqHouse,
                'unlocks_house_id'  => $unlocksHouse,
                'created_at'        => $now,
                'updated_at'        => $now,
                'deleted_at'        => null,
            ]);
        }
    }
}
