<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KhitomerSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $this->call([
            KhitomerStorySeeder::class,
            KhitomerPostSeeder::class,
        ]);

        activity()->enableLogging();
    }
}
