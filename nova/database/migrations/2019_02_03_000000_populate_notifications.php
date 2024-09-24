<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Foundation\Enums\NotificationAudience;
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
            ['name' => 'User deleted their account', 'key' => 'user-deleted-account'],
            ['name' => 'Site contact message', 'key' => 'site-contact-message', 'description' => 'When a user submits the contact form', 'database' => false, 'mail' => true],
        ]);

        $group = collect([
            ['name' => 'New story started', 'key' => 'story-started', 'description' => "When a story's status has been changed to current", 'notes' => 'A Discord notification (if enabled) will only be sent when a story is moved from a status of Upcoming to a status of Current OR if a new story is created with an initial status of Current. No other status transitions will trigger this Discord notification.'],
            ['name' => 'Running story ended', 'key' => 'story-ended', 'description' => "When a story's status has been changed from current to completed", 'notes' => 'A Discord notification (if enabled) will only be sent when a story is moved from a status of Current to a status of Completed. No other status transitions will trigger this Discord notification.'],
            ['name' => 'Post published', 'key' => 'post-published', 'description' => 'When a post has been finished and published for players', 'notes' => "Any accent color set for this notification will be ignored in favor of the post type's accent color."],
        ]);

        $personal = collect([
            ['name' => 'Pending character approved', 'key' => 'pending-character-approved'],
            ['name' => 'Pending character denied', 'key' => 'pending-character-denied'],
            ['name' => 'Account created', 'key' => 'account-created', 'mail' => true, 'mail_default' => true, 'database' => false, 'database_default' => false],
            ['name' => 'Character author added to post', 'key' => 'character-author-added-to-post'],
            ['name' => 'Character author removed from post', 'key' => 'character-author-removed-from-post'],
            ['name' => 'User author added to post', 'key' => 'user-author-added-to-post'],
            ['name' => 'User author removed from post', 'key' => 'user-author-removed-from-post'],
            ['name' => 'Draft post discarded', 'key' => 'draft-post-discarded'],
            ['name' => 'Post saved', 'key' => 'post-saved'],
            ['name' => 'Application ready for review', 'key' => 'application-ready-for-review'],
            ['name' => 'Application accepted', 'key' => 'application-accepted', 'mail' => true, 'mail_default' => true, 'database' => false, 'database_default' => false],
            ['name' => 'Application denied', 'key' => 'application-denied', 'mail' => true, 'mail_default' => true, 'database' => false, 'database_default' => false],
            ['name' => 'Discussion message received', 'key' => 'discussion-message-received'],
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
        NotificationType::create(array_merge(
            $data,
            ['audience' => $audience]
        ));
    }
}
