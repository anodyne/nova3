<?php

declare(strict_types=1);

namespace Nova\Announcements\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Announcements\Models\Announcement;

class AnnouncementPublished
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Announcement $announcement
    ) {}
}
