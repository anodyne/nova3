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

            ['group_id' => 2, 'name_id' => 2, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o5.png'],
            ['group_id' => 2, 'name_id' => 3, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o4.png'],
            ['group_id' => 2, 'name_id' => 4, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o3.png'],
            ['group_id' => 2, 'name_id' => 5, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o2.png'],
            ['group_id' => 2, 'name_id' => 6, 'base_image' => 'officer/yellow.png', 'overlay_image' => 'navy_gold/o1.png'],

            ['group_id' => 3, 'name_id' => 2, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o5.png'],
            ['group_id' => 3, 'name_id' => 3, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o4.png'],
            ['group_id' => 3, 'name_id' => 4, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o3.png'],
            ['group_id' => 3, 'name_id' => 5, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o2.png'],
            ['group_id' => 3, 'name_id' => 6, 'base_image' => 'officer/teal.png', 'overlay_image' => 'navy_gold/o1.png'],
        ];

        collect($items)->each([RankItem::class, 'create']);

        activity()->enableLogging();
    }
}
