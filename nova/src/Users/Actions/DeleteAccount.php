<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Users\Models\User;

class DeleteAccount
{
    use AsAction;

    public function handle(User $user): void
    {
        DB::transaction(function () use ($user): void {
            AnnouncementNotification::query()
                ->whereIn('announcement_id', $user->announcements()
                    ->where('status', '!=', PublishStatus::Published)
                    ->select('id'))
                ->delete();

            $user->announcements()->where('status', '!=', PublishStatus::Published)->delete();

            AnnouncementNotification::query()->user($user->id)->delete();

            // Application::query()->user($user->id);

            DiscussionNotification::query()->user($user->id)->delete();

            $user->notes()->delete();

            $user->logins()->delete();

            $user->clearMediaCollection('avatar');

            $user->onboardings()->delete();

            $user->statusHistories()->delete();

            $user->delete();
        });
    }
}
