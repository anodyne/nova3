<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Users\Models\User;

class MarkAnnouncementRead
{
    use AsAction;

    public function handle(Announcement $announcement, User $user): void
    {
        AnnouncementNotification::query()
            ->announcement($announcement->id)
            ->user($user->id)
            ->update(['is_seen' => true]);
    }
}
