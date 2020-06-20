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
            'Lieutenant JG',
            'Ensign',

            'Colonel',
            'Lieutenant Colonel',
            'Major',
            'Marine Captain',
            '1st Lieutenant',
            '2nd Lieutenant',

            'Master Warrant Officer',
            'Chief Warrant Officer 1st Class',
            'Chief Warrant Officer 2nd Class',
            'Chief Warrant Officer 3rd Class',
            'Warrant Officer',

            'Master Chief Petty Officer',
            'Senior Chief Petty Officer',
            'Chief Petty Officer',
            'Petty Officer 1st Class',
            'Petty Officer 2nd Class',
            'Petty Officer 3rd Class',
            'Crewman 1st Class',
            'Crewman 2nd Class',
            'Crewman 3rd Class',

            'Sergeant Major',
            'Master Sergeant',
            'Gunnery Sergeant',
            'Staff Sergeant',
            'Sergeant',
            'Corporal',
            'Private 1st Class',
            'Private E-2',
            'Private E-1',
        ];

        collect($names)->each(function ($name) {
            RankName::create(['name' => $name]);
        });

        activity()->enableLogging();
    }
}
