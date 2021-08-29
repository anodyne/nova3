<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdateStoryResponse extends Responsable
{
    public string $view = 'stories.edit';
}
