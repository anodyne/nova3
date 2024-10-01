<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowPostsTimelineResponse extends Responsable
{
    public ?string $subnav = 'timeline';

    public string $view = 'stories.show-posts-timeline';
}
