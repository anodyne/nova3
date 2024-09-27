<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowStoriesTimelineResponse extends Responsable
{
    public ?string $subnav = 'timeline';

    public string $view = 'stories.show-stories-timeline';
}
