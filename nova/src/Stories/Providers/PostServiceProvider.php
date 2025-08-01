<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Nova\Stories\Livewire\PostAuthors;
use Nova\Stories\Livewire\PostAuthorsEditor;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Livewire\PostDetails;
use Nova\Stories\Livewire\PostPosition;
use Nova\Stories\Livewire\PostPositionEditor;
use Nova\Stories\Livewire\PostPublish;
use Nova\Stories\Livewire\PostRatings;
use Nova\Stories\Livewire\PostRatingsEditor;
use Nova\Stories\Livewire\PostSummary;
use Nova\Stories\Livewire\PostSummaryEditor;
use Nova\Stories\Livewire\PostSetup;
use Nova\Stories\Livewire\DraftPostsList;
use Nova\Stories\Livewire\RecentPublishedPostsList;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Livewire\PostsTimeline;
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
            'posts-authors' => PostAuthors::class,
            'posts-authors-editor' => PostAuthorsEditor::class,
            'posts-composer' => PostComposer::class,
            'posts-details' => PostDetails::class,
            'posts-position' => PostPosition::class,
            'posts-position-editor' => PostPositionEditor::class,
            'posts-publish' => PostPublish::class,
            'posts-ratings' => PostRatings::class,
            'posts-ratings-editor' => PostRatingsEditor::class,
            'posts-summary' => PostSummary::class,
            'posts-summary-editor' => PostSummaryEditor::class,
            'posts-setup' => PostSetup::class,
            'posts-draft-posts-list' => DraftPostsList::class,
            'posts-recent-published-posts-list' => RecentPublishedPostsList::class,
            'posts-list' => PostsList::class,
            'posts-timeline' => PostsTimeline::class,
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
