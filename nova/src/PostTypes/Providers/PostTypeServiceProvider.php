<?php

namespace Nova\PostTypes\Providers;

use Nova\DomainServiceProvider;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Policies\PostTypePolicy;
use Nova\PostTypes\Responses\ShowPostTypeResponse;
use Nova\PostTypes\Responses\CreatePostTypeResponse;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;
use Nova\PostTypes\Responses\ShowAllPostTypesResponse;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        PostType::class => PostTypePolicy::class,
    ];

    protected $responsables = [
        CreatePostTypeResponse::class,
        ShowAllPostTypesResponse::class,
        ShowPostTypeResponse::class,
        UpdatePostTypeResponse::class,
    ];
}
