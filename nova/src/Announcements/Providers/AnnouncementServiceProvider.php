<?php

declare(strict_types=1);

namespace Nova\Announcements\Providers;

use Nova\Announcements\Events\AnnouncementPublished;
use Nova\Announcements\Listeners\SendAnnouncementPublishedNotificationToDiscord;
use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Models\Announcement;
use Nova\DomainServiceProvider;

class AnnouncementServiceProvider extends DomainServiceProvider
{
    public function eventListeners(): array
    {
        return [
            AnnouncementPublished::class => [
                SendAnnouncementPublishedNotificationToDiscord::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'announcements-list' => AnnouncementsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'announcement' => Announcement::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'ann_' => Announcement::class,
        ];
    }
}
