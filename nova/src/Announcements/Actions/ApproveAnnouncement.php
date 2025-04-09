<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;

class ApproveAnnouncement
{
    use AsAction;

    public function handle(Announcement $original): Announcement
    {
        return DB::transaction(function () use ($original) {
            $announcement = Announcement::find($original->id);

            $announcement->update([
                'status' => PublishStatus::Published,
                'published_at' => Date::now(),
            ]);

            NotifyUsers::run($announcement);

            return $announcement->refresh();
        });
    }
}
