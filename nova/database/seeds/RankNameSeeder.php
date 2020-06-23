<?php

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankName;

class RankNameSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $names = [
            ['name' => 'Captain', 'sort' => 1],
            ['name' => 'Commander', 'sort' => 2],
            ['name' => 'Lieutenant Commander', 'sort' => 3],
            ['name' => 'Lieutenant', 'sort' => 4],
            ['name' => 'Lieutenant JG', 'sort' => 5],
            ['name' => 'Ensign', 'sort' => 6],

            ['name' => 'Colonel', 'sort' => 7],
            ['name' => 'Lieutenant Colonel', 'sort' => 8],
            ['name' => 'Major', 'sort' => 9],
            ['name' => 'Marine Captain', 'sort' => 10],
            ['name' => '1st Lieutenant', 'sort' => 11],
            ['name' => '2nd Lieutenant', 'sort' => 12],

            ['name' => 'Master Warrant Officer', 'sort' => 13],
            ['name' => 'Chief Warrant Officer 1st Class', 'sort' => 14],
            ['name' => 'Chief Warrant Officer 2nd Class', 'sort' => 15],
            ['name' => 'Chief Warrant Officer 3rd Class', 'sort' => 16],
            ['name' => 'Warrant Officer', 'sort' => 17],

            ['name' => 'Master Chief Petty Officer', 'sort' => 18],
            ['name' => 'Senior Chief Petty Officer', 'sort' => 19],
            ['name' => 'Chief Petty Officer', 'sort' => 20],
            ['name' => 'Petty Officer 1st Class', 'sort' => 21],
            ['name' => 'Petty Officer 2nd Class', 'sort' => 22],
            ['name' => 'Petty Officer 3rd Class', 'sort' => 23],
            ['name' => 'Crewman 1st Class', 'sort' => 24],
            ['name' => 'Crewman 2nd Class', 'sort' => 25],
            ['name' => 'Crewman 3rd Class', 'sort' => 26],

            ['name' => 'Sergeant Major', 'sort' => 27],
            ['name' => 'Master Sergeant', 'sort' => 28],
            ['name' => 'Gunnery Sergeant', 'sort' => 29],
            ['name' => 'Staff Sergeant', 'sort' => 30],
            ['name' => 'Sergeant', 'sort' => 31],
            ['name' => 'Corporal', 'sort' => 32],
            ['name' => 'Private 1st Class', 'sort' => 33],
            ['name' => 'Private E-2', 'sort' => 34],
            ['name' => 'Private E-1', 'sort' => 35],
        ];

        collect($names)->each([RankName::class, 'create']);

        activity()->enableLogging();
    }
}
