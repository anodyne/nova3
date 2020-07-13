<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Models\PostType;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Policies\PostTypePolicy;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        PostType::class => PostTypePolicy::class,
        Story::class => StoryPolicy::class,
    ];
}
