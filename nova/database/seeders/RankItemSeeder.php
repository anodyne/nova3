<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankItem;

class RankItemSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $items = [
            ['group_id' => 1, 'name_id' => 1, 'base_image' => 'red.png', 'overlay_image' => 'naval/o6.png'],
            ['group_id' => 1, 'name_id' => 2, 'base_image' => 'red.png', 'overlay_image' => 'naval/o5.png'],
            ['group_id' => 1, 'name_id' => 3, 'base_image' => 'red.png', 'overlay_image' => 'naval/o4.png'],
            ['group_id' => 1, 'name_id' => 4, 'base_image' => 'red.png', 'overlay_image' => 'naval/o3.png'],
            ['group_id' => 1, 'name_id' => 5, 'base_image' => 'red.png', 'overlay_image' => 'naval/o2.png'],
            ['group_id' => 1, 'name_id' => 6, 'base_image' => 'red.png', 'overlay_image' => 'naval/o1.png'],
            ['group_id' => 1, 'name_id' => 18, 'base_image' => 'red.png', 'overlay_image' => 'naval/e9.png'],
            ['group_id' => 1, 'name_id' => 19, 'base_image' => 'red.png', 'overlay_image' => 'naval/e8.png'],
            ['group_id' => 1, 'name_id' => 20, 'base_image' => 'red.png', 'overlay_image' => 'naval/e7.png'],
            ['group_id' => 1, 'name_id' => 21, 'base_image' => 'red.png', 'overlay_image' => 'naval/e6.png'],
            ['group_id' => 1, 'name_id' => 22, 'base_image' => 'red.png', 'overlay_image' => 'naval/e5.png'],
            ['group_id' => 1, 'name_id' => 23, 'base_image' => 'red.png', 'overlay_image' => 'naval/e4.png'],
            ['group_id' => 1, 'name_id' => 24, 'base_image' => 'red.png', 'overlay_image' => 'naval/e3.png'],
            ['group_id' => 1, 'name_id' => 25, 'base_image' => 'red.png', 'overlay_image' => 'naval/e2.png'],
            ['group_id' => 1, 'name_id' => 26, 'base_image' => 'red.png', 'overlay_image' => 'naval/e1.png'],

            ['group_id' => 2, 'name_id' => 2, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o5.png'],
            ['group_id' => 2, 'name_id' => 3, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o4.png'],
            ['group_id' => 2, 'name_id' => 4, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o3.png'],
            ['group_id' => 2, 'name_id' => 5, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o2.png'],
            ['group_id' => 2, 'name_id' => 6, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o1.png'],
            ['group_id' => 2, 'name_id' => 18, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e9.png'],
            ['group_id' => 2, 'name_id' => 19, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e8.png'],
            ['group_id' => 2, 'name_id' => 20, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e7.png'],
            ['group_id' => 2, 'name_id' => 21, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e6.png'],
            ['group_id' => 2, 'name_id' => 22, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e5.png'],
            ['group_id' => 2, 'name_id' => 23, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e4.png'],
            ['group_id' => 2, 'name_id' => 24, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e3.png'],
            ['group_id' => 2, 'name_id' => 25, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e2.png'],
            ['group_id' => 2, 'name_id' => 26, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e1.png'],

            ['group_id' => 3, 'name_id' => 2, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o5.png'],
            ['group_id' => 3, 'name_id' => 3, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o4.png'],
            ['group_id' => 3, 'name_id' => 4, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o3.png'],
            ['group_id' => 3, 'name_id' => 5, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o2.png'],
            ['group_id' => 3, 'name_id' => 6, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o1.png'],
            ['group_id' => 3, 'name_id' => 18, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e9.png'],
            ['group_id' => 3, 'name_id' => 19, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e8.png'],
            ['group_id' => 3, 'name_id' => 20, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e7.png'],
            ['group_id' => 3, 'name_id' => 21, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e6.png'],
            ['group_id' => 3, 'name_id' => 22, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e5.png'],
            ['group_id' => 3, 'name_id' => 23, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e4.png'],
            ['group_id' => 3, 'name_id' => 24, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e3.png'],
            ['group_id' => 3, 'name_id' => 25, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e2.png'],
            ['group_id' => 3, 'name_id' => 26, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e1.png'],

            ['group_id' => 4, 'name_id' => 7, 'base_image' => 'green.png', 'overlay_image' => 'marine/o6.png'],
            ['group_id' => 4, 'name_id' => 8, 'base_image' => 'green.png', 'overlay_image' => 'marine/o5.png'],
            ['group_id' => 4, 'name_id' => 9, 'base_image' => 'green.png', 'overlay_image' => 'marine/o4.png'],
            ['group_id' => 4, 'name_id' => 10, 'base_image' => 'green.png', 'overlay_image' => 'marine/o3.png'],
            ['group_id' => 4, 'name_id' => 11, 'base_image' => 'green.png', 'overlay_image' => 'marine/o2.png'],
            ['group_id' => 4, 'name_id' => 12, 'base_image' => 'green.png', 'overlay_image' => 'marine/o1.png'],
            ['group_id' => 4, 'name_id' => 27, 'base_image' => 'green.png', 'overlay_image' => 'marine/e9.png'],
            ['group_id' => 4, 'name_id' => 28, 'base_image' => 'green.png', 'overlay_image' => 'marine/e8.png'],
            ['group_id' => 4, 'name_id' => 29, 'base_image' => 'green.png', 'overlay_image' => 'marine/e7.png'],
            ['group_id' => 4, 'name_id' => 30, 'base_image' => 'green.png', 'overlay_image' => 'marine/e6.png'],
            ['group_id' => 4, 'name_id' => 31, 'base_image' => 'green.png', 'overlay_image' => 'marine/e5.png'],
            ['group_id' => 4, 'name_id' => 32, 'base_image' => 'green.png', 'overlay_image' => 'marine/e4.png'],
            ['group_id' => 4, 'name_id' => 33, 'base_image' => 'green.png', 'overlay_image' => 'marine/e3.png'],
            ['group_id' => 4, 'name_id' => 34, 'base_image' => 'green.png', 'overlay_image' => 'marine/e2.png'],
            ['group_id' => 4, 'name_id' => 35, 'base_image' => 'green.png', 'overlay_image' => 'marine/e1.png'],
        ];

        collect($items)->each([RankItem::class, 'create']);

        activity()->enableLogging();
    }
}
