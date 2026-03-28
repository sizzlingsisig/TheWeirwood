<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HousesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $houses = [
            ['House Stark', 'Winter is Coming',
                "House Stark of Winterfell is the principal noble house of the North, renowned for their honor, resilience, and ancient lineage tracing back to the First Men. For thousands of years, the Starks have ruled as Kings in the North and later as Wardens, holding Winterfell as their ancestral seat and upholding the old gods and traditions of the North.\n\nTheir words, 'Winter is Coming,' serve as a solemn reminder of the harsh northern climate and the ever-present threat of danger. The Starks are respected for their sense of duty and justice, and their family has played a pivotal role in the history and fate of Westeros.",
                'houses/Stark.svg',
                75, 40, 15,
            ],
            ['House Lannister', 'Hear Me Roar!',
                "House Lannister of Casterly Rock is one of the wealthiest and most influential families in Westeros, ruling over the Westerlands from their seat at the imposing Casterly Rock. Known for their golden hair, cunning, and immense riches from the gold mines beneath their lands, the Lannisters have long been power players in the politics of the realm.\n\nTheir official motto, 'Hear Me Roar!', is less well known than their unofficial saying, 'A Lannister always pays his debts.' The Lannisters are famed for their ambition, political acumen, and willingness to do whatever it takes to maintain their family's legacy and power.",
                'houses/Lannister.svg',
                30, 80, 35,
            ],
            ['House Targaryen', 'Fire and Blood',
                "House Targaryen, once the royal house of the Seven Kingdoms, is famed for its Valyrian ancestry, dragons, and the conquest of Westeros by Aegon the Conqueror. The Targaryens ruled from the Iron Throne for nearly three centuries, their bloodline marked by silver hair, violet eyes, and a tradition of marrying within the family to keep their Valyrian heritage pure.\n\nTheir words, 'Fire and Blood,' reflect their legacy of power, magic, and at times, madness. Though their dragons are gone and their dynasty shattered, the Targaryen name still inspires awe and fear throughout the realm.",
                'houses/Targaryen.svg',
                50, 70, 25,
            ],
            ['House Baratheon', 'Ours is the Fury',
                "House Baratheon of Storm's End is a noble house founded during the Targaryen conquest, known for their tempestuous nature and formidable warriors. Their seat, Storm's End, is a legendary fortress on the storm-lashed coast of the Stormlands, said to be impenetrable.\n\nThe Baratheons are characterized by their boldness, pride, and quick tempers. Their words, 'Ours is the Fury,' capture the house's fierce spirit and readiness to meet any challenge head-on, whether in battle or in the game of thrones.",
                'houses/Baratheon.svg',
                55, 65, 20,
            ],
            ['House Tyrell', 'Growing Strong',
                "House Tyrell of Highgarden is the ruling house of the Reach, renowned for their vast wealth, fertile lands, and chivalric traditions. Though their rise to power came after the extinction of House Gardener, the Tyrells have become one of the most influential families in Westeros, able to field massive armies and command the loyalty of many bannermen.\n\nTheir words, 'Growing Strong,' reflect both their prosperity and their ambition. The Tyrells are known for their political savvy, generosity, and the beauty and grace of their members, most notably Queen Margaery and the formidable Lady Olenna, the Queen of Thorns.",
                'houses/Tyrell.svg',
                60, 50, 30,
            ],
            ['House Martell', 'Unbowed, Unbent, Unbroken',
                "House Martell of Sunspear rules the hot, arid land of Dorne in the far south of Westeros. Descended from the union of the Andal adventurer Mors Martell and the Rhoynish warrior-queen Nymeria, the Martells are known for their fierce independence, unique customs, and tolerance for gender equality in inheritance and rule.\n\nTheir words, 'Unbowed, Unbent, Unbroken,' speak to their resilience and refusal to be conquered, even by the Targaryens. The Martells are proud, passionate, and deeply loyal to their own, with a history of both fierce resistance and shrewd diplomacy.",
                'houses/Martell.svg',
                65, 55, 18,
            ],
            ['House Tully', 'Family, Duty, Honor',
                null,
                'houses/Tully.svg',
                70, 45, 10,
            ],
            ['House Arryn', 'As High as Honor',
                "House Arryn of the Eyrie is one of the oldest and most noble families in Westeros, ruling the Vale from their impregnable mountain stronghold. The Arryns trace their lineage back to the Andal invasion and have long been known for their sense of honor, justice, and chivalry.\n\nTheir words, 'As High as Honor,' reflect their lofty ideals and the literal heights of their ancestral seat. The Arryns are respected for their integrity and have played a key role in the politics and defense of the realm for centuries.",
                'houses/Arryn.svg',
                80, 35, 5,
            ],
            ['House Greyjoy', 'We Do Not Sow',
                "House Greyjoy of Pyke rules the Iron Islands, a harsh and windswept archipelago off the western coast of Westeros. The Greyjoys are fierce seafarers and raiders, following the Old Way of the ironborn, which prizes strength, independence, and taking what one can by force.\n\nTheir words, 'We Do Not Sow,' reflect their disdain for farming and trade, preferring to reap the spoils of the sea. The Greyjoys are proud, ruthless, and ever eager to assert their dominance over both sea and land, with a long history of rebellion and ambition.",
                'houses/Greyjoy.svg',
                25, 75, 40,
            ],
        ];
        foreach ($houses as [$name, $motto, $description, $imagePath, $honor, $power, $debt]) {
            DB::table('houses')->updateOrInsert(['name' => $name], [
                'motto' => $motto,
                'description' => $description,
                'sigil_image_path' => $imagePath,
                'starting_honor' => $honor,
                'starting_power' => $power,
                'starting_debt' => $debt,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]);
        }
    }
}
