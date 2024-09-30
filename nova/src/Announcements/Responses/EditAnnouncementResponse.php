<?php

declare(strict_types=1);

namespace Nova\Announcements\Responses;

use Nova\Foundation\Responses\Responsable;

class EditAnnouncementResponse extends Responsable
{
    public string $view = 'announcements.edit';
}
