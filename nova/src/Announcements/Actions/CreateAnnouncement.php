<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;

class CreateAnnouncement
{
    use AsAction;

    public function handle(AnnouncementData $data): Announcement
    {
        $announcement = $data->user()
            ->announcements()
            ->create(array_merge($data->all(), [
                'published_at' => $data->published ? now() : null,
            ]));

        NotifyUsers::runIf($data->published, $announcement, $data);

        return $announcement;
    }
}
