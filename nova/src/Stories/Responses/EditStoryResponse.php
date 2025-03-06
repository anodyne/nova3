<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class EditStoryResponse extends Responsable
{
    public ?string $subnav = 'storytelling';

    public string $view = 'stories.edit';
}
