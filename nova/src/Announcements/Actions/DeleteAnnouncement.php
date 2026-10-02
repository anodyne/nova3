<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Actions\Action;

class DeleteAnnouncement extends Action
{
    public function handle(Announcement $announcement): Announcement
    {
        $announcement->notifications()->delete();

        return tap($announcement)->delete();
    }
}
