<?php

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankName;

class RankNameSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $names = [
            'Captain',
            'Commander',
            'Lieutenant Commander',
            'Lieutenant',
            'Ensign',
        ];

        collect($names)->each(function ($name) {
            RankName::create(['name' => $name]);
        });

        activity()->enableLogging();
    }
}
