<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
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
        /** @var User $currentUser */
        $currentUser = Auth::user();

        User::query()->active()->chunk(100, function ($users) use ($announcement, $currentUser): void {
            DB::transaction(function () use ($users, $announcement, $currentUser): void {
                $notifications = [];
                $usersToEmail = [];

                foreach ($users as $user) {
                    $notifications[] = [
                        'announcement_id' => $announcement->id,
                        'user_id' => $user->id,
                        'is_seen' => $user->id === $currentUser->id,
                        'created_at' => Date::now(),
                        'updated_at' => Date::now(),
                    ];

                    if ($currentUser->id !== $user->id) {
                        $usersToEmail[] = $user;
                    }
                }

                AnnouncementNotification::upsert(
                    $notifications,
                    ['announcement_id', 'user_id'],
                    ['is_seen', 'updated_at']
                );

                foreach ($usersToEmail as $userToEmail) {
                    $userToEmail->notify(new AnnouncementPublished($announcement));
                }
            });
        });
    }
}
