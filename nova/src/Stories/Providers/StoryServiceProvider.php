<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Story::class => StoryPolicy::class,
    ];

    protected $responsables = [
        ShowAllStoriesResponse::class,
    ];
}
