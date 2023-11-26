<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\DomainServiceProvider;
use Nova\Stories\Events\StoryEnded;
use Nova\Stories\Events\StoryStarted;
use Nova\Stories\Listeners\SendStoryEndedNotificationToDiscord;
use Nova\Stories\Listeners\SendStoryStartedNotificationToDiscord;
use Nova\Stories\Livewire\DeleteStories;
use Nova\Stories\Livewire\StoriesList;
use Nova\Stories\Livewire\StoriesTimeline;
use Nova\Stories\Livewire\StoryHierarchy;
use Nova\Stories\Livewire\StoryPostsList;
use Nova\Stories\Models\Story;
use Nova\Stories\Spotlight\AddStory;
use Nova\Stories\Spotlight\EditStory;
use Nova\Stories\Spotlight\ViewStories;
use Nova\Stories\Spotlight\ViewStory;

class StoryServiceProvider extends DomainServiceProvider
{
    public function eventListeners(): array
    {
        return [
            StoryStarted::class => [
                SendStoryStartedNotificationToDiscord::class,
            ],
            StoryEnded::class => [
                SendStoryEndedNotificationToDiscord::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'stories-delete' => DeleteStories::class,
            'stories-hierarchy' => StoryHierarchy::class,
            'stories-list' => StoriesList::class,
            'stories-posts-list' => StoryPostsList::class,
            'stories-timeline' => StoriesTimeline::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'story' => Story::class,
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
