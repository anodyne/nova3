<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\ReadPostModal;
use Nova\Posts\Livewire\SelectDayModal;
use Nova\Posts\Livewire\SelectLocationModal;
use Nova\Posts\Livewire\SelectStoryModal;
use Nova\Posts\Livewire\SelectTimeModal;
use Nova\Posts\Spotlight\WritePost;

class PostServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'posts:compose' => ComposePost::class,
            'posts:read-post-modal' => ReadPostModal::class,
            'posts:select-day-modal' => SelectDayModal::class,
            'posts:select-location-modal' => SelectLocationModal::class,
            'posts:select-story-modal' => SelectStoryModal::class,
            'posts:select-time-modal' => SelectTimeModal::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            WritePost::class,
        ];
    }
}
