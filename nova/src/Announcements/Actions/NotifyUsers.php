<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Announcements\Notifications\AnnouncementPublished;
use Nova\Users\Models\User;

class NotifyUsers
{
    use AsAction;

    public function handle(Announcement $announcement, AnnouncementData $data): void
    {
        $usersToNotify = User::active()->get();

        $usersToNotify->each(function (User $user) use ($announcement, $data) {
            AnnouncementNotification::create([
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
                'is_seen' => $user->id === $data->user()->id,
            ]);

            if ($data->user()->id !== $user->id) {
                $user->notify(new AnnouncementPublished($announcement));
            }
        });
    }
}
