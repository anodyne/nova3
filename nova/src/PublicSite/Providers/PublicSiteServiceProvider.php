<?php

declare(strict_types=1);

namespace Nova\PublicSite\Providers;

use Nova\DomainServiceProvider;
use Nova\PublicSite\Livewire\PostsTimeline;
use Nova\PublicSite\Livewire\StoriesTimeline;

class PublicSiteServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'public-posts-timeline' => PostsTimeline::class,
            'public-stories-timeline' => StoriesTimeline::class,
        ];
    }
}
