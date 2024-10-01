<?php

declare(strict_types=1);

namespace Nova\Announcements\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Announcements\Models\Announcement;

class AnnouncementDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Announcement $announcement
    ) {}
}
