<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\DomainServiceProvider;
use Nova\Stories\Livewire\DeleteStories;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Livewire\StoryHierarchy;
use Nova\Stories\Livewire\StoryStatus;
use Nova\Stories\Livewire\StoryTimeline;
use Nova\Stories\Models\Story;
use Nova\Stories\Policies\StoryPolicy;
use Nova\Stories\Spotlight\AddStory;
use Nova\Stories\Spotlight\EditStory;
use Nova\Stories\Spotlight\ViewStories;
use Nova\Stories\Spotlight\ViewStory;

class StoryServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'stories:delete-story' => DeleteStories::class,
            'stories:hierarchy' => StoryHierarchy::class,
            'stories:posts-list' => PostsList::class,
            'stories:status' => StoryStatus::class,
            'stories:timeline' => StoryTimeline::class,
        ];
    }

    public function policies(): array
    {
        return [
            Story::class => StoryPolicy::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddStory::class,
            EditStory::class,
            ViewStories::class,
            ViewStory::class,
        ];
    }
}
