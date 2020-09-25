<?php

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\PickPostType;
use Nova\Posts\Models\Post;
use Nova\Posts\Policies\PostPolicy;
use Nova\Posts\Responses\CreatePostResponse;
use Nova\Posts\Responses\PickPostTypeResponse;

class PostServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'posts:compose' => ComposePost::class,
        'posts:pick-post-type' => PickPostType::class,
    ];

    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    protected $responsables = [
        CreatePostResponse::class,
        PickPostTypeResponse::class,
    ];
}
