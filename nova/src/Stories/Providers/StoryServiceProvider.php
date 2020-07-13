<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Responses;
use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Models\PostType;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Policies\PostTypePolicy;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        PostType::class => PostTypePolicy::class,
        Story::class => StoryPolicy::class,
    ];

    protected $responsables = [
        Responses\PostTypes\CreatePostTypeResponse::class,
        Responses\PostTypes\ShowAllPostTypesResponse::class,
        Responses\PostTypes\ShowPostTypeResponse::class,
        Responses\PostTypes\UpdatePostTypeResponse::class,
    ];
}
