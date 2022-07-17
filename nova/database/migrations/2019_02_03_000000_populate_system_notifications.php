<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
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
        $groupNotifications = [
            ['name' => 'Story post published', 'key' => 'story-post-published', 'category' => 'group'],
        ];

        $individualNotifications = [
            ['name' => 'Private message received', 'key' => 'private-message-received', 'category' => 'individual'],
            ['name' => 'Story post saved', 'key' => 'story-post-saved', 'category' => 'individual'],
            ['name' => 'Added as author on a story post', 'key' => 'author-added-post', 'category' => 'individual'],
            ['name' => 'Removed as author on a story post', 'key' => 'author-removed-post', 'category' => 'individual'],
        ];

        SystemNotification::unguarded(function () use ($groupNotifications, $individualNotifications) {
            collect($groupNotifications)->each([SystemNotification::class, 'create']);
            collect($individualNotifications)->each([SystemNotification::class, 'create']);
        });
    }
}
