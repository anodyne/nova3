<?php

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankGroup;

class RankGroupSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $groups = ['Command', 'Operations', 'Science', 'Marines'];

        collect($groups)->each(function ($group) {
            RankGroup::create(['name' => $group]);
        });

        activity()->enableLogging();
    }
}
