<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\DomainServiceProvider;
use Nova\Stories\Livewire\DeleteStories;
use Nova\Stories\Livewire\StoryHierarchy;
use Nova\Stories\Livewire\StoryStatus;
use Nova\Stories\Models\Story;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Responses\CreateStoryResponse;
use Nova\Stories\Responses\DeleteStoryResponse;
use Nova\Stories\Responses\ReorderStoriesResponse;
use Nova\Stories\Responses\ShowAllStoriesResponse;
use Nova\Stories\Responses\ShowStoryResponse;
use Nova\Stories\Responses\UpdateStoryResponse;
use Nova\Stories\Spotlight\CreateStory;
use Nova\Stories\Spotlight\EditStory;
use Nova\Stories\Spotlight\ViewStory;

class StoryServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'stories:delete-story' => DeleteStories::class,
            'stories:hierarchy' => StoryHierarchy::class,
            'stories:status' => StoryStatus::class,
        ];
    }

    public function policies(): array
    {
        return [
            Story::class => StoryPolicy::class,
        ];
    }

    public function responsables(): array
    {
        return [
            CreateStoryResponse::class,
            DeleteStoryResponse::class,
            ReorderStoriesResponse::class,
            ShowAllStoriesResponse::class,
            ShowStoryResponse::class,
            UpdateStoryResponse::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            CreateStory::class,
            EditStory::class,
            ViewStory::class,
        ];
    }
}
