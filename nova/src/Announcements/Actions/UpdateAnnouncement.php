<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;

class UpdateAnnouncement
{
    use AsAction;

    public function handle(Announcement $announcement, AnnouncementData $data): Announcement
    {
        return DB::transaction(function () use ($announcement, $data): Announcement {
            $publishing = $announcement->status !== PublishStatus::Published && $data->status === PublishStatus::Published;

            $announcement->update([
                ...$data->toArray(),
                ...['published_at' => $publishing ? now() : $announcement->published_at],
            ]);

            NotifyUsers::runIf($publishing, $announcement, $data);

            return $announcement;
        });
    }
}
