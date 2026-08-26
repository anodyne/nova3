<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Themes\Models\Theme;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        Theme::factory(10)->create();

        activity()->enableLogging();
    }
}
