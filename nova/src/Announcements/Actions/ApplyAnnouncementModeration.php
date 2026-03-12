<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Announcements\Data\AnnouncementData;
use Nova\Foundation\Enums\PublishStatus;

class ApplyAnnouncementModeration
{
    use AsAction;

    public function handle(AnnouncementData $data): AnnouncementData
    {
        if ($data->status === PublishStatus::Published && $data->user()->is_moderated) {
            return $data->append(['status' => PublishStatus::Pending]);
        }

        return $data;
    }
}
