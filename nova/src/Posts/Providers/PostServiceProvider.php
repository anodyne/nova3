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
    public function livewireComponents(): array
    {
        return [
            'posts:compose' => ComposePost::class,
            'posts:pick-post-type' => PickPostType::class,
            'posts:write' => WritePost::class,
        ];
    }

    public function policies(): array
    {
        return [
            Post::class => PostPolicy::class,
        ];
    }

    public function responsables(): array
    {
        return [
            ComposePostResponse::class,
            SelectPostTypeResponse::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            SpotlightWritePost::class,
        ];
    }
}
