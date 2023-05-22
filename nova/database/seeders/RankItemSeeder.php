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
            ['group_id' => 1, 'name_id' => 1, 'base_image' => 'red.png', 'overlay_image' => 'naval/o6.png', 'order_column' => 0],
            ['group_id' => 1, 'name_id' => 2, 'base_image' => 'red.png', 'overlay_image' => 'naval/o5.png', 'order_column' => 1],
            ['group_id' => 1, 'name_id' => 3, 'base_image' => 'red.png', 'overlay_image' => 'naval/o4.png', 'order_column' => 2],
            ['group_id' => 1, 'name_id' => 4, 'base_image' => 'red.png', 'overlay_image' => 'naval/o3.png', 'order_column' => 3],
            ['group_id' => 1, 'name_id' => 5, 'base_image' => 'red.png', 'overlay_image' => 'naval/o2.png', 'order_column' => 4],
            ['group_id' => 1, 'name_id' => 6, 'base_image' => 'red.png', 'overlay_image' => 'naval/o1.png', 'order_column' => 5],
            ['group_id' => 1, 'name_id' => 18, 'base_image' => 'red.png', 'overlay_image' => 'naval/e9.png', 'order_column' => 6],
            ['group_id' => 1, 'name_id' => 19, 'base_image' => 'red.png', 'overlay_image' => 'naval/e8.png', 'order_column' => 7],
            ['group_id' => 1, 'name_id' => 20, 'base_image' => 'red.png', 'overlay_image' => 'naval/e7.png', 'order_column' => 8],
            ['group_id' => 1, 'name_id' => 21, 'base_image' => 'red.png', 'overlay_image' => 'naval/e6.png', 'order_column' => 9],
            ['group_id' => 1, 'name_id' => 22, 'base_image' => 'red.png', 'overlay_image' => 'naval/e5.png', 'order_column' => 10],
            ['group_id' => 1, 'name_id' => 23, 'base_image' => 'red.png', 'overlay_image' => 'naval/e4.png', 'order_column' => 11],
            ['group_id' => 1, 'name_id' => 24, 'base_image' => 'red.png', 'overlay_image' => 'naval/e3.png', 'order_column' => 12],
            ['group_id' => 1, 'name_id' => 25, 'base_image' => 'red.png', 'overlay_image' => 'naval/e2.png', 'order_column' => 13],
            ['group_id' => 1, 'name_id' => 26, 'base_image' => 'red.png', 'overlay_image' => 'naval/e1.png', 'order_column' => 14],

            ['group_id' => 2, 'name_id' => 2, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o5.png', 'order_column' => 0],
            ['group_id' => 2, 'name_id' => 3, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o4.png', 'order_column' => 1],
            ['group_id' => 2, 'name_id' => 4, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o3.png', 'order_column' => 2],
            ['group_id' => 2, 'name_id' => 5, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o2.png', 'order_column' => 3],
            ['group_id' => 2, 'name_id' => 6, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/o1.png', 'order_column' => 4],
            ['group_id' => 2, 'name_id' => 18, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e9.png', 'order_column' => 5],
            ['group_id' => 2, 'name_id' => 19, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e8.png', 'order_column' => 6],
            ['group_id' => 2, 'name_id' => 20, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e7.png', 'order_column' => 7],
            ['group_id' => 2, 'name_id' => 21, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e6.png', 'order_column' => 8],
            ['group_id' => 2, 'name_id' => 22, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e5.png', 'order_column' => 9],
            ['group_id' => 2, 'name_id' => 23, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e4.png', 'order_column' => 10],
            ['group_id' => 2, 'name_id' => 24, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e3.png', 'order_column' => 11],
            ['group_id' => 2, 'name_id' => 25, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e2.png', 'order_column' => 12],
            ['group_id' => 2, 'name_id' => 26, 'base_image' => 'yellow.png', 'overlay_image' => 'naval/e1.png', 'order_column' => 13],

            ['group_id' => 3, 'name_id' => 2, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o5.png', 'order_column' => 0],
            ['group_id' => 3, 'name_id' => 3, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o4.png', 'order_column' => 1],
            ['group_id' => 3, 'name_id' => 4, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o3.png', 'order_column' => 2],
            ['group_id' => 3, 'name_id' => 5, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o2.png', 'order_column' => 3],
            ['group_id' => 3, 'name_id' => 6, 'base_image' => 'teal.png', 'overlay_image' => 'naval/o1.png', 'order_column' => 4],
            ['group_id' => 3, 'name_id' => 18, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e9.png', 'order_column' => 5],
            ['group_id' => 3, 'name_id' => 19, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e8.png', 'order_column' => 6],
            ['group_id' => 3, 'name_id' => 20, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e7.png', 'order_column' => 7],
            ['group_id' => 3, 'name_id' => 21, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e6.png', 'order_column' => 8],
            ['group_id' => 3, 'name_id' => 22, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e5.png', 'order_column' => 9],
            ['group_id' => 3, 'name_id' => 23, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e4.png', 'order_column' => 10],
            ['group_id' => 3, 'name_id' => 24, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e3.png', 'order_column' => 11],
            ['group_id' => 3, 'name_id' => 25, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e2.png', 'order_column' => 12],
            ['group_id' => 3, 'name_id' => 26, 'base_image' => 'teal.png', 'overlay_image' => 'naval/e1.png', 'order_column' => 13],

            ['group_id' => 4, 'name_id' => 7, 'base_image' => 'green.png', 'overlay_image' => 'marine/o6.png', 'order_column' => 0],
            ['group_id' => 4, 'name_id' => 8, 'base_image' => 'green.png', 'overlay_image' => 'marine/o5.png', 'order_column' => 1],
            ['group_id' => 4, 'name_id' => 9, 'base_image' => 'green.png', 'overlay_image' => 'marine/o4.png', 'order_column' => 2],
            ['group_id' => 4, 'name_id' => 10, 'base_image' => 'green.png', 'overlay_image' => 'marine/o3.png', 'order_column' => 3],
            ['group_id' => 4, 'name_id' => 11, 'base_image' => 'green.png', 'overlay_image' => 'marine/o2.png', 'order_column' => 4],
            ['group_id' => 4, 'name_id' => 12, 'base_image' => 'green.png', 'overlay_image' => 'marine/o1.png', 'order_column' => 5],
            ['group_id' => 4, 'name_id' => 27, 'base_image' => 'green.png', 'overlay_image' => 'marine/e9.png', 'order_column' => 6],
            ['group_id' => 4, 'name_id' => 28, 'base_image' => 'green.png', 'overlay_image' => 'marine/e8.png', 'order_column' => 7],
            ['group_id' => 4, 'name_id' => 29, 'base_image' => 'green.png', 'overlay_image' => 'marine/e7.png', 'order_column' => 8],
            ['group_id' => 4, 'name_id' => 30, 'base_image' => 'green.png', 'overlay_image' => 'marine/e6.png', 'order_column' => 9],
            ['group_id' => 4, 'name_id' => 31, 'base_image' => 'green.png', 'overlay_image' => 'marine/e5.png', 'order_column' => 10],
            ['group_id' => 4, 'name_id' => 32, 'base_image' => 'green.png', 'overlay_image' => 'marine/e4.png', 'order_column' => 11],
            ['group_id' => 4, 'name_id' => 33, 'base_image' => 'green.png', 'overlay_image' => 'marine/e3.png', 'order_column' => 12],
            ['group_id' => 4, 'name_id' => 34, 'base_image' => 'green.png', 'overlay_image' => 'marine/e2.png', 'order_column' => 13],
            ['group_id' => 4, 'name_id' => 35, 'base_image' => 'green.png', 'overlay_image' => 'marine/e1.png', 'order_column' => 14],
        ];

        collect($items)->each([RankItem::class, 'create']);

        activity()->enableLogging();
    }
}
