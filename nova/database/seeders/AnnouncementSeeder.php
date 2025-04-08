<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Nova\Announcements\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Date::setTestNow(Date::now());

        Announcement::factory()->count(25)->create();

        activity()->enableLogging();
    }
}
