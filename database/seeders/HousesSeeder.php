<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
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
                "House Tully of Riverrun rules the Riverlands from their ancestral seat at Riverrun, a fortress at the confluence of the Red Fork and the Tumblestone rivers. The Tullys rose to prominence during the Targaryen conquest and have since been master of the rivers, controlling trade and movement through the fertile lands.\n\nTheir words, 'Family, Duty, Honor,' reflect the Tully emphasis on kinship and loyalty. The Tullys are known for their political pragmatism and the beauty of their domain, though they have often found themselves caught between larger powers.",
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

        // $this->seedFakerHouses();
    }

    // protected function seedFakerHouses(): void
    // {
    //     $faker = Faker::create();
    //     $now = Carbon::now();

    //     $housePrefixes = ['House', 'Clan', 'Family', 'Dynasty', 'Brotherhood', 'Order'];
    //     $houseNames = [
    //         'Blackwood', 'Mormont', 'Glover', 'Karstark', 'Umber', 'Manderly', 'Bolton', 'Flint', 'Ryswell', 'Dustin',
    //         'Hightower', 'Redwyne', 'Oakheart', 'Fossoway', 'Bulwer', 'Crane', 'Meryon', 'Harlaw', 'Greyiron', 'Drumm',
    //         'Dayne', 'Yronwood', 'Fowler', 'Allyrion', 'Qorgyle', 'Santagar', 'Dalt', 'Wyl', 'Mandrake', 'Lorch',
    //         'Clegane', 'Karhook', 'Casterly', 'Sarsfield', 'Lefford', 'Lannister', 'Payne', 'Swyft', 'Westerling', 'Risley',
    //         'Moore', 'Mooton', 'Vance', 'Blackwood', 'Bracken', 'Mallister', 'Darren', 'Deddings', 'Frey', 'Roote',
    //     ];

    //     $mottos = [
    //         'By Sword or Word', 'Strength and Honor', 'None So Fierce', 'The Watchful Eye', 'From This Day Forward',
    //         'Honor, Not Honors', 'Our Word is Gold', 'Blood and Fire', 'The Righteous Path', 'Pride Before the Fall',
    //         'The Stone Shall Rise', 'Light in Darkness', 'Sworn to Protect', 'Justice Before Mercy', 'The Brave Endure',
    //         'Walls of Stone', 'Together We Stand', 'Ever Forward', 'No Retreat', 'The Dawn Awaits',
    //         'Truth Will Prevail', 'Wisdom Above All', 'The Old Ways', 'Steel and Spirit', 'The Hidden Truth',
    //         'Guardians of the Realm', 'The Eternal Flame', 'From Ashes We Rise', 'The Last Stand', 'Silent but Deadly',
    //     ];

    //     $descriptions = [
    //         'An ancient house with a storied past, known throughout the realm for their @ 다양한特质. Their @ 시그니처特征 has earned them both respect and fear among their peers.',
    //         'A proud house whose members are @著名于 for their @技能. Though not among the greatest houses, they maintain their honor with @决心.',
    //         'Rulers of @地理区域, this house has endured for centuries through @策略. Their @传统 is spoken of in whispers throughout the land.',
    //         'Once @辉煌的过去, this house now seeks to reclaim former glory. Their @口号 reflects their @愿望.',
    //         'A @神秘 house whose origins are shrouded in mystery. They say their @信条 has protected them from @威胁 for generations.',
    //         'Known for their @特殊能力 in battle, this house commands respect on the @战场. Their @遗产 dates back to the @时代.',
    //         'This house rose to power through @手段 during the @时期. Their @统治 has been marked by @事件.',
    //         'Guardians of the @地方, these @标题 are sworn to protect the @守护对象. Their @誓言 is unbreakable.',
    //         'A house of @发明者 and @思想家, they have contributed greatly to the @领域. Their @贡献 is remembered to this day.',
    //         'The @姓氏 are @描述人 from the @地区. Their @特征 make them stand out among the nobility.',
    //     ];

    //     $fakerHouses = [];

    //     for ($i = 0; $i < 20; $i++) {
    //         $prefix = $faker->randomElement($housePrefixes);
    //         $name = $faker->randomElement($houseNames);
    //         $fullName = "$prefix $name";

    //         $description = $faker->randomElement($descriptions);
    //         $description = str_replace('@ 다양한特质', $faker->word(), $description);
    //         $description = str_replace('@ 시그니처特征', $faker->word(), $description);
    //         $description = str_replace('@著名于', $faker->word(), $description);
    //         $description = str_replace('@技能', $faker->word(), $description);
    //         $description = str_replace('@决心', $faker->word(), $description);
    //         $description = str_replace('@地理区域', $faker->word().' '.$faker->word(), $description);
    //         $description = str_replace('@策略', $faker->word(), $description);
    //         $description = str_replace('@传统', $faker->word(), $description);
    //         $description = str_replace('@愿望', $faker->word(), $description);
    //         $description = str_replace('@辉煌的过去', $faker->sentence(3), $description);
    //         $description = str_replace('@神秘', $faker->word(), $description);
    //         $description = str_replace('@信条', $faker->word(), $description);
    //         $description = str_replace('@威胁', $faker->word(), $description);
    //         $description = str_replace('@特殊能力', $faker->word(), $description);
    //         $description = str_replace('@战场', $faker->word(), $description);
    //         $description = str_replace('@遗产', $faker->word(), $description);
    //         $description = str_replace('@时代', $faker->word(), $description);
    //         $description = str_replace('@手段', $faker->word(), $description);
    //         $description = str_replace('@时期', $faker->word(), $description);
    //         $description = str_replace('@统治', $faker->word(), $description);
    //         $description = str_replace('@事件', $faker->word(), $description);
    //         $description = str_replace('@地方', $faker->word(), $description);
    //         $description = str_replace('@标题', $faker->word(), $description);
    //         $description = str_replace('@守护对象', $faker->word(), $description);
    //         $description = str_replace('@誓言', $faker->word(), $description);
    //         $description = str_replace('@发明者', $faker->word(), $description);
    //         $description = str_replace('@思想家', $faker->word(), $description);
    //         $description = str_replace('@领域', $faker->word(), $description);
    //         $description = str_replace('@贡献', $faker->word(), $description);
    //         $description = str_replace('@描述人', $faker->word(), $description);
    //         $description = str_replace('@地区', $faker->word(), $description);
    //         $description = str_replace('@特征', $faker->word(), $description);

    //         $fakerHouses[] = [
    //             'name' => $fullName,
    //             'motto' => $faker->randomElement($mottos),
    //             'description' => $description,
    //             'sigil_image_path' => null,
    //             'starting_honor' => $faker->numberBetween(10, 90),
    //             'starting_power' => $faker->numberBetween(10, 90),
    //             'starting_debt' => $faker->numberBetween(5, 45),
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //             'deleted_at' => null,
    //         ];
    //     }

    //     foreach ($fakerHouses as $house) {
    //         DB::table('houses')->updateOrInsert(['name' => $house['name']], $house);
    //     }
    // }
}
