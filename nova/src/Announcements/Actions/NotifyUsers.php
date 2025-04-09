<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Announcements\Notifications\AnnouncementPublished;
use Nova\Users\Models\User;

class NotifyUsers
{
    use AsAction;

    public function handle(Announcement $announcement): void
    {
        DB::transaction(function () use ($announcement) {
            $usersToNotify = User::active()->get();

            $usersToNotify->each(function (User $user) use ($announcement) {
                /** @var User $currentUser */
                $currentUser = Auth::user();

                AnnouncementNotification::create([
                    'announcement_id' => $announcement->id,
                    'user_id' => $user->id,
                    'is_seen' => $user->id === $currentUser->id,
                ]);

                if ($currentUser->id !== $user->id) {
                    $user->notify(new AnnouncementPublished($announcement));
                }
            });
        });
    }
}
