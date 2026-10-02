<?php

declare(strict_types=1);

namespace Nova\Announcements\Actions;

use Nova\Announcements\Data\AnnouncementData;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\Enums\PublishStatus;

class ApplyAnnouncementModeration extends Action
{
    public function handle(AnnouncementData $data): AnnouncementData
    {
        if ($data->status === PublishStatus::Published && $data->user()->is_moderated) {
            return $data->append(['status' => PublishStatus::Pending]);
        }

        return $data;
    }
}
