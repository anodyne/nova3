<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\SelectDayModal;
use Nova\Posts\Livewire\SelectLocationModal;
use Nova\Posts\Livewire\SelectTimeModal;
use Nova\Posts\Models\Post;
use Nova\Posts\Policies\PostPolicy;
use Nova\Posts\Spotlight\WritePost as SpotlightWritePost;

class PostServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'posts:compose' => ComposePost::class,
            'posts:select-day-modal' => SelectDayModal::class,
            'posts:select-location-modal' => SelectLocationModal::class,
            'posts:select-time-modal' => SelectTimeModal::class,
        ];
    }

    public function policies(): array
    {
        return [
            Post::class => PostPolicy::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            SpotlightWritePost::class,
        ];
    }
}
