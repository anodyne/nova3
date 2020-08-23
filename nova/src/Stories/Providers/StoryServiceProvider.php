<?php

namespace Nova\Stories\Providers;

use Nova\Stories\Models\Story;
use Nova\DomainServiceProvider;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Livewire\DeleteStories;
use Nova\Stories\Livewire\StoryHierarchy;
use Nova\Stories\Responses\ShowStoryResponse;
use Nova\Stories\Responses\CreateStoryResponse;
use Nova\Stories\Responses\DeleteStoryResponse;
use Nova\Stories\Responses\ReorderStoriesResponse;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class StoryServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'stories:delete-story' => DeleteStories::class,
        'stories:hierarchy' => StoryHierarchy::class,
    ];

    protected $policies = [
        Story::class => StoryPolicy::class,
    ];

    protected $responsables = [
        CreateStoryResponse::class,
        DeleteStoryResponse::class,
        ReorderStoriesResponse::class,
        ShowAllStoriesResponse::class,
        ShowStoryResponse::class,
    ];
}
