<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Ranks\Models\RankName;

class RankNameSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $names = [
            ['name' => 'Captain', 'order_column' => 1],
            ['name' => 'Commander', 'order_column' => 2],
            ['name' => 'Lieutenant Commander', 'order_column' => 3],
            ['name' => 'Lieutenant', 'order_column' => 4],
            ['name' => 'Lieutenant JG', 'order_column' => 5],
            ['name' => 'Ensign', 'order_column' => 6],

            ['name' => 'Colonel', 'order_column' => 7],
            ['name' => 'Lieutenant Colonel', 'order_column' => 8],
            ['name' => 'Major', 'order_column' => 9],
            ['name' => 'Marine Captain', 'order_column' => 10],
            ['name' => '1st Lieutenant', 'order_column' => 11],
            ['name' => '2nd Lieutenant', 'order_column' => 12],

            ['name' => 'Master Warrant Officer', 'order_column' => 13],
            ['name' => 'Chief Warrant Officer 1st Class', 'order_column' => 14],
            ['name' => 'Chief Warrant Officer 2nd Class', 'order_column' => 15],
            ['name' => 'Chief Warrant Officer 3rd Class', 'order_column' => 16],
            ['name' => 'Warrant Officer', 'order_column' => 17],

            ['name' => 'Master Chief Petty Officer', 'order_column' => 18],
            ['name' => 'Senior Chief Petty Officer', 'order_column' => 19],
            ['name' => 'Chief Petty Officer', 'order_column' => 20],
            ['name' => 'Petty Officer 1st Class', 'order_column' => 21],
            ['name' => 'Petty Officer 2nd Class', 'order_column' => 22],
            ['name' => 'Petty Officer 3rd Class', 'order_column' => 23],
            ['name' => 'Crewman 1st Class', 'order_column' => 24],
            ['name' => 'Crewman 2nd Class', 'order_column' => 25],
            ['name' => 'Crewman 3rd Class', 'order_column' => 26],

            ['name' => 'Sergeant Major', 'order_column' => 27],
            ['name' => 'Master Sergeant', 'order_column' => 28],
            ['name' => 'Gunnery Sergeant', 'order_column' => 29],
            ['name' => 'Staff Sergeant', 'order_column' => 30],
            ['name' => 'Sergeant', 'order_column' => 31],
            ['name' => 'Corporal', 'order_column' => 32],
            ['name' => 'Private 1st Class', 'order_column' => 33],
            ['name' => 'Private E-2', 'order_column' => 34],
            ['name' => 'Private E-1', 'order_column' => 35],
        ];

        collect($names)->each([RankName::class, 'create']);

        activity()->enableLogging();
    }
}
