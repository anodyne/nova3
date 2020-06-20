<?php

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankItem;

class RankItemSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $items = [
            ['group_id' => 1, 'name_id' => 1, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o6.png'],
            ['group_id' => 1, 'name_id' => 2, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o5.png'],
            ['group_id' => 1, 'name_id' => 3, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o4.png'],
            ['group_id' => 1, 'name_id' => 4, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o3.png'],
            ['group_id' => 1, 'name_id' => 5, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o2.png'],
            ['group_id' => 1, 'name_id' => 6, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_gold/o1.png'],
            ['group_id' => 1, 'name_id' => 18, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e9.png'],
            ['group_id' => 1, 'name_id' => 19, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e8.png'],
            ['group_id' => 1, 'name_id' => 20, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e7.png'],
            ['group_id' => 1, 'name_id' => 21, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e6.png'],
            ['group_id' => 1, 'name_id' => 22, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e5.png'],
            ['group_id' => 1, 'name_id' => 23, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e4.png'],
            ['group_id' => 1, 'name_id' => 24, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e3.png'],
            ['group_id' => 1, 'name_id' => 25, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e2.png'],
            ['group_id' => 1, 'name_id' => 26, 'base_image' => 'officer/red.png', 'overlay_image' => 'navy_enlisted/e1.png'],

            ['group_id' => 2, 'name_id' => 2, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o5.png'],
            ['group_id' => 2, 'name_id' => 3, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o4.png'],
            ['group_id' => 2, 'name_id' => 4, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o3.png'],
            ['group_id' => 2, 'name_id' => 5, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o2.png'],
            ['group_id' => 2, 'name_id' => 6, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o1.png'],
            ['group_id' => 2, 'name_id' => 18, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e9.png'],
            ['group_id' => 2, 'name_id' => 19, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e8.png'],
            ['group_id' => 2, 'name_id' => 20, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e7.png'],
            ['group_id' => 2, 'name_id' => 21, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e6.png'],
            ['group_id' => 2, 'name_id' => 22, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e5.png'],
            ['group_id' => 2, 'name_id' => 23, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e4.png'],
            ['group_id' => 2, 'name_id' => 24, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e3.png'],
            ['group_id' => 2, 'name_id' => 25, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e2.png'],
            ['group_id' => 2, 'name_id' => 26, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_enlisted/e1.png'],

            ['group_id' => 3, 'name_id' => 2, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o5.png'],
            ['group_id' => 3, 'name_id' => 3, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o4.png'],
            ['group_id' => 3, 'name_id' => 4, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o3.png'],
            ['group_id' => 3, 'name_id' => 5, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o2.png'],
            ['group_id' => 3, 'name_id' => 6, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o1.png'],
            ['group_id' => 3, 'name_id' => 18, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e9.png'],
            ['group_id' => 3, 'name_id' => 19, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e8.png'],
            ['group_id' => 3, 'name_id' => 20, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e7.png'],
            ['group_id' => 3, 'name_id' => 21, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e6.png'],
            ['group_id' => 3, 'name_id' => 22, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e5.png'],
            ['group_id' => 3, 'name_id' => 23, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e4.png'],
            ['group_id' => 3, 'name_id' => 24, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e3.png'],
            ['group_id' => 3, 'name_id' => 25, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e2.png'],
            ['group_id' => 3, 'name_id' => 26, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_enlisted/e1.png'],

            ['group_id' => 4, 'name_id' => 7, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o6.png'],
            ['group_id' => 4, 'name_id' => 8, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o5.png'],
            ['group_id' => 4, 'name_id' => 9, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o4.png'],
            ['group_id' => 4, 'name_id' => 10, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o3.png'],
            ['group_id' => 4, 'name_id' => 11, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o2.png'],
            ['group_id' => 4, 'name_id' => 12, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/o1.png'],
            ['group_id' => 4, 'name_id' => 27, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e9.png'],
            ['group_id' => 4, 'name_id' => 28, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e8.png'],
            ['group_id' => 4, 'name_id' => 29, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e7.png'],
            ['group_id' => 4, 'name_id' => 30, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e6.png'],
            ['group_id' => 4, 'name_id' => 31, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e5.png'],
            ['group_id' => 4, 'name_id' => 32, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e4.png'],
            ['group_id' => 4, 'name_id' => 33, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e3.png'],
            ['group_id' => 4, 'name_id' => 34, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e2.png'],
            ['group_id' => 4, 'name_id' => 35, 'base_image' => 'officer/green.png', 'overlay_image' => 'marines/e1.png'],
        ];

        collect($items)->each([RankItem::class, 'create']);

        activity()->enableLogging();
    }
}
