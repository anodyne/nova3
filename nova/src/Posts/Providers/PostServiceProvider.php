<?php

namespace Nova\Posts\Providers;

use Nova\Posts\Models\Post;
use Nova\DomainServiceProvider;
use Nova\Posts\Policies\PostPolicy;
use Nova\Posts\Responses\CreatePostResponse;
use Nova\Posts\Responses\PickPostTypeResponse;

class PostServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    protected $responsables = [
        CreatePostResponse::class,
        PickPostTypeResponse::class,
    ];
}
