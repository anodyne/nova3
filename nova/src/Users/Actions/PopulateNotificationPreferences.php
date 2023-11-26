<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Models\NotificationType;
use Nova\Users\Models\User;

class PopulateNotificationPreferences
{
    use AsAction;

    public function handle(User $user): User
    {
        NotificationType::query()
            ->whereIn('audience', [
                NotificationAudience::personal,
                NotificationAudience::group,
            ])
            ->get()
            ->each(fn (NotificationType $notification) => $notification->userNotificationPreferences()->create([
                'user_id' => $user->id,
                'database' => $notification->database_default,
                'mail' => $notification->mail_default,
                'discord' => false,
            ]));

        return $user->refresh();
    }
}
