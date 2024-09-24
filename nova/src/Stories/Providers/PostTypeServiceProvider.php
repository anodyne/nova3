<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\DomainServiceProvider;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\PostType;
use Nova\Stories\Spotlight\AddPostType;
use Nova\Stories\Spotlight\EditPostType;
use Nova\Stories\Spotlight\ViewPostType;
use Nova\Stories\Spotlight\ViewPostTypes;

class PostTypeServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'post-types-list' => PostTypesList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'post-type' => PostType::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'ptyp_' => PostType::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddPostType::class,
            EditPostType::class,
            ViewPostType::class,
            ViewPostTypes::class,
        ];
    }
}
