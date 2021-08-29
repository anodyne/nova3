<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllStoriesResponse extends Responsable
{
    public string $view = 'stories.index';
}
