<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Announcements\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Announcement::factory()->count(25)->create();

        activity()->enableLogging();
    }
}
