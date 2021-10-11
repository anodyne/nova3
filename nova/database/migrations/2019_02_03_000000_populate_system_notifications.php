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

        $this->populateGroupSystemNotifications();

        $this->populateIndividualSystemNotifications();

        activity()->enableLogging();
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('system_notifications');
    }

    protected function populateGroupSystemNotifications(): void
    {
        $notifications = [
            ['name' => 'New story post published', 'key' => 'story-post-published', 'category' => 'group'],
            ['name' => 'New user application received', 'key' => 'user-application-received', 'category' => 'group'],
            ['name' => 'Created character pending approval', 'key' => 'character-pending-approval', 'category' => 'group'],
        ];

        SystemNotification::unguarded(function () use ($notifications) {
            collect($notifications)->each([SystemNotification::class, 'create']);
        });
    }

    protected function populateIndividualSystemNotifications(): void
    {
        $notifications = [
            ['name' => 'Private message received', 'key' => 'private-message-received', 'category' => 'individual'],
        ];

        SystemNotification::unguarded(function () use ($notifications) {
            collect($notifications)->each([SystemNotification::class, 'create']);
        });
    }
}
