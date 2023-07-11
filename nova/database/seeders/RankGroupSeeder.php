<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankGroup;

class RankGroupSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $groups = [
            ['name' => 'Admiralty', 'order_column' => 0],
            ['name' => 'Command', 'order_column' => 1],
            ['name' => 'Operations', 'order_column' => 2],
            ['name' => 'Science', 'order_column' => 3],
            ['name' => 'Marines', 'order_column' => 4],
        ];

        collect($groups)->each([RankGroup::class, 'create']);

        activity()->enableLogging();
    }
}
