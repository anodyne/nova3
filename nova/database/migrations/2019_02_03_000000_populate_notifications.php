<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Enums\NotificationChannelStatus;
use Nova\Foundation\Models\NotificationType;

class PopulateNotifications extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populateNotificationTypes();

        activity()->enableLogging();
    }

    public function down()
    {
        NotificationType::truncate();
    }

    protected function populateNotificationTypes(): void
    {
        $admin = collect([
            ['name' => 'Character requires approval', 'key' => 'character-requires-approval'],
        ]);

        $group = collect([
            ['name' => 'Character author added to post', 'key' => 'character-author-added-to-post'],
            ['name' => 'Character author removed from post', 'key' => 'character-author-removed-from-post'],
            ['name' => 'Draft post discarded', 'key' => 'draft-post-discarded'],
            ['name' => 'Post published', 'key' => 'post-published'],
            ['name' => 'Post saved', 'key' => 'post-saved'],
            ['name' => 'User author added to post', 'key' => 'user-author-added-to-post'],
            ['name' => 'User author removed from post', 'key' => 'user-author-removed-from-post'],
            ['name' => 'New story started', 'key' => 'new-story-started'],
        ]);

        $personal = collect([
            ['name' => 'Pending character approved', 'key' => 'pending-character-approved'],
            ['name' => 'Pending character denied', 'key' => 'pending-character-denied'],
            ['name' => 'Account created', 'key' => 'account-created'],
        ]);

        NotificationType::unguarded(function () use ($admin, $group, $personal) {
            $admin->each(
                fn ($notification) => $this->createNotificationType($notification, NotificationAudience::admin)
            );

            $group->each(
                fn ($notification) => $this->createNotificationType($notification, NotificationAudience::group)
            );

            $personal->each(
                fn ($notification) => $this->createNotificationType($notification, NotificationAudience::personal)
            );
        });
    }

    protected function createNotificationType(array $data, NotificationAudience $audience): void
    {
        $notificationType = NotificationType::create(array_merge(
            $data,
            [
                'audience' => $audience,
                'database' => NotificationChannelStatus::enabled,
                'mail' => NotificationChannelStatus::disabled,
                'discord' => NotificationChannelStatus::disabled,
            ]
        ));

        $notificationType->userNotificationPreferences()->create([
            'database' => NotificationChannelStatus::enabled,
            'mail' => NotificationChannelStatus::disabled,
            'discord' => NotificationChannelStatus::disabled,
        ]);
    }
}
