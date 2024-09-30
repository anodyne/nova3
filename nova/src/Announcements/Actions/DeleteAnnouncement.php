<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\Announcement;

class DeleteAnnouncement
{
    use AsAction;

    public function handle(Announcement $announcement): Announcement
    {
        return tap($announcement)->delete();
    }
}
