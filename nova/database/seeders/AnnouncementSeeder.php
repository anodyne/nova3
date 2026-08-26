<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Announcements\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $rows = Announcement::factory()
            ->count(25)
            ->make()
            ->map(fn ($announcement): array => array_merge(
                $announcement->getAttributes(),
                ['id' => str()->uuid7()->toString(), 'created_at' => $now, 'updated_at' => $now]
            ))
            ->all();

        DB::table('announcements')->insert($rows);
    }
}
