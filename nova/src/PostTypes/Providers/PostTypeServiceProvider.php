<?php

declare(strict_types=1);

namespace Nova\PostTypes\Providers;

use Nova\DomainServiceProvider;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Policies\PostTypePolicy;
use Nova\PostTypes\Responses\CreatePostTypeResponse;
use Nova\PostTypes\Responses\DeletePostTypeResponse;
use Nova\PostTypes\Responses\ShowAllPostTypesResponse;
use Nova\PostTypes\Responses\ShowPostTypeResponse;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;

class PostTypeServiceProvider extends DomainServiceProvider
{
    protected array $policies = [
        PostType::class => PostTypePolicy::class,
    ];

    protected array $responsables = [
        CreatePostTypeResponse::class,
        DeletePostTypeResponse::class,
        ShowAllPostTypesResponse::class,
        ShowPostTypeResponse::class,
        UpdatePostTypeResponse::class,
    ];
}
