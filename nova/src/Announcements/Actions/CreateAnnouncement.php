<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;

class CreateAnnouncement
{
    use AsAction;

    public function handle(AnnouncementData $data): Announcement
    {
        return DB::transaction(function () use ($data): Announcement {
            $data = ApplyAnnouncementModeration::run($data);

            $announcement = $data->user()
                ->announcements()
                ->create(array_merge(
                    $data->toArray(),
                    ['published_at' => $data->status === PublishStatus::Published ? now() : null]
                ));

            NotifyUsers::runIf($data->status === PublishStatus::Published, $announcement);

            return $announcement;
        });
    }
}
