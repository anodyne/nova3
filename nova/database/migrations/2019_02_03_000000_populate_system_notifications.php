<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Nova\Foundation\Enums\SystemNotificationType;
use Nova\Foundation\Models\SystemNotification;

class PopulateSystemNotifications extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populateSystemNotifications();

        activity()->enableLogging();
    }

    public function down()
    {
        SystemNotification::truncate();
    }

    protected function populateSystemNotifications(): void
    {
        $administrativeNotifications = [
            ['name' => 'Player application received', 'key' => 'application-received', 'type' => SystemNotificationType::admin],
        ];

        $collectiveNotifications = [
            ['name' => 'Story post published', 'key' => 'story-post-published', 'type' => SystemNotificationType::collective],
        ];

        $personalNotifications = [
            ['name' => 'Private message received', 'key' => 'private-message-received', 'type' => SystemNotificationType::personal],
            ['name' => 'Story post saved', 'key' => 'story-post-saved', 'type' => SystemNotificationType::personal],
            ['name' => 'Added as author on a story post', 'key' => 'author-added-post', 'type' => SystemNotificationType::personal],
            ['name' => 'Removed as author on a story post', 'key' => 'author-removed-post', 'type' => SystemNotificationType::personal],
        ];

        SystemNotification::unguarded(function () use ($administrativeNotifications, $collectiveNotifications, $personalNotifications) {
            collect($administrativeNotifications)->each([SystemNotification::class, 'create']);
            collect($collectiveNotifications)->each([SystemNotification::class, 'create']);
            collect($personalNotifications)->each([SystemNotification::class, 'create']);
        });
    }
}
