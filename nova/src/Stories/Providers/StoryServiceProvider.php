<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Responses\ShowStoryResponse;
use Nova\Stories\Responses\ReorderStoriesResponse;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Story::class => StoryPolicy::class,
    ];

    protected $responsables = [
        ReorderStoriesResponse::class,
        ShowAllStoriesResponse::class,
        ShowStoryResponse::class,
    ];
}
