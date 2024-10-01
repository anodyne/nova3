<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;

class UpdateAnnouncement
{
    use AsAction;

    public function handle(Announcement $announcement, AnnouncementData $data): Announcement
    {
        $publishing = $announcement->published === false && $data->published === true;

        $announcement->update(array_merge($data->all(), [
            'published_at' => $publishing ? now() : $announcement->published_at,
        ]));

        NotifyUsers::runIf($publishing, $announcement, $data);

        return $announcement;
    }
}
