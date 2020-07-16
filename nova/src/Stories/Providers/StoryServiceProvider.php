<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Policies\StoryPolicy;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Story::class => StoryPolicy::class,
    ];
}
