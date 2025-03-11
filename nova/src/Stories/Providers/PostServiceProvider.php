<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\DomainServiceProvider;
use Nova\Stories\Actions\PruneAbandonedPosts;
use Nova\Stories\Events\PostCreating;
use Nova\Stories\Events\PostPublished;
use Nova\Stories\Listeners\SendPostPublishedNotificationToDiscord;
use Nova\Stories\Listeners\SetDefaultContentRatings;
use Nova\Stories\Livewire;
use Nova\Stories\Models\Post;
use Nova\Stories\Spotlight\ViewWritingDashboard;
use Nova\Stories\Spotlight\WritePost;

class PostServiceProvider extends DomainServiceProvider
{
    public function consoleCommands(): array
    {
        return [
            PruneAbandonedPosts::class,
        ];
    }

    public function eventListeners(): array
    {
        return [
            PostCreating::class => [
                SetDefaultContentRatings::class,
            ],
            PostPublished::class => [
                SendPostPublishedNotificationToDiscord::class,
            ],
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'posts-authors' => Livewire\PostAuthors::class,
            'posts-authors-editor' => Livewire\PostAuthorsEditor::class,
            'posts-composer' => Livewire\PostComposer::class,
            'posts-details' => Livewire\PostDetails::class,
            'posts-position' => Livewire\PostPosition::class,
            'posts-position-editor' => Livewire\PostPositionEditor::class,
            'posts-publish' => Livewire\PostPublish::class,
            'posts-ratings' => Livewire\PostRatings::class,
            'posts-ratings-editor' => Livewire\PostRatingsEditor::class,
            'posts-summary' => Livewire\PostSummary::class,
            'posts-summary-editor' => Livewire\PostSummaryEditor::class,
            'posts-setup' => Livewire\PostSetup::class,
            'posts-draft-posts-list' => Livewire\DraftPostsList::class,
            'posts-recent-published-posts-list' => Livewire\RecentPublishedPostsList::class,
            'posts-list' => Livewire\PostsList::class,
            'posts-timeline' => Livewire\PostsTimeline::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'post' => Post::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'post_' => Post::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            WritePost::class,
            ViewWritingDashboard::class,
        ];
    }
}
