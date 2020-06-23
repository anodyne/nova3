<?php

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankGroup;

class RankGroupSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $groups = [
            ['name' => 'Command', 'sort' => 0],
            ['name' => 'Operations', 'sort' => 1],
            ['name' => 'Science', 'sort' => 2],
            ['name' => 'Marines', 'sort' => 3],
        ];

        collect($groups)->each([RankGroup::class, 'create']);

        activity()->enableLogging();
    }
}
