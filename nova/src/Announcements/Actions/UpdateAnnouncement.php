<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Events\AnnouncementPublished;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Enums\PublishStatus;

class UpdateAnnouncement
{
    use AsAction;

    public function handle(Announcement $announcement, AnnouncementData $data): Announcement
    {
        return DB::transaction(function () use ($announcement, $data): Announcement {
            $wasPublishing = $announcement->status !== PublishStatus::Published && $data->status === PublishStatus::Published;

            if ($wasPublishing) {
                $data = ApplyAnnouncementModeration::run($data);
            }

            $announcement->update($this->setUpdateData(announcement: $announcement, data: $data, wasPublishing: $wasPublishing));

            $announcement = $announcement->fresh();

            AnnouncementPublished::dispatchIf($announcement->status === PublishStatus::Published, $announcement);

            NotifyUsers::runIf($announcement->status === PublishStatus::Published, $announcement);

            return $announcement;
        });
    }

    private function setUpdateData(Announcement $announcement, AnnouncementData $data, bool $wasPublishing): array
    {
        if (! $wasPublishing) {
            return [
                ...$data->toArray(),
                ...['published_at' => $announcement->published_at],
            ];
        }

        return [
            ...$data->toArray(),
            ...['published_at' => $data->status === PublishStatus::Published ? Date::now() : null],
        ];
    }
}
