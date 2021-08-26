<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\PickPostType;
use Nova\Posts\Livewire\WritePost;
use Nova\Posts\Models\Post;
use Nova\Posts\Policies\PostPolicy;
use Nova\Posts\Responses\ComposePostResponse;
use Nova\Posts\Responses\SelectPostTypeResponse;
use Nova\Posts\Spotlight\WritePost as SpotlightWritePost;

class PostServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'posts:compose' => ComposePost::class,
        'posts:pick-post-type' => PickPostType::class,
        'posts:write' => WritePost::class,
    ];

    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    protected $responsables = [
        ComposePostResponse::class,
        SelectPostTypeResponse::class,
    ];

    public function spotlightCommands(): array
    {
        return [
            SpotlightWritePost::class,
        ];
    }
}
