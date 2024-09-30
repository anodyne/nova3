<?php

declare(strict_types=1);

namespace Nova\Announcements\Providers;

use Nova\Announcements\Livewire\AnnouncementsList;
use Nova\Announcements\Livewire\CreateAnnouncement;
use Nova\Announcements\Models\Announcement;
use Nova\DomainServiceProvider;

class AnnouncementServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'announcements-list' => AnnouncementsList::class,
            'announcements-create' => CreateAnnouncement::class,
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
