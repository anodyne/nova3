<?php

declare(strict_types=1);

namespace Nova\Stories\Providers;

use Livewire\Livewire;
use Nova\DomainServiceProvider;
use Nova\Stories\Actions\PruneAbandonedPosts;
use Nova\Stories\Events\PostCreating;
use Nova\Stories\Events\PostPublished;
use Nova\Stories\Listeners\SendPostPublishedNotificationToDiscord;
use Nova\Stories\Listeners\SetDefaultContentRatings;
use Nova\Stories\Livewire\MyDraftsList;
use Nova\Stories\Livewire\PostsList;
use Nova\Stories\Livewire\PostsTimeline;
use Nova\Stories\Livewire\ReadPostModal;
use Nova\Stories\Livewire\SelectPostPositionModal;
use Nova\Stories\Livewire\Steps\ComposePostStep;
use Nova\Stories\Livewire\Steps\PublishPostStep;
use Nova\Stories\Livewire\Steps\SetupPostStep;
use Nova\Stories\Livewire\WritePostWizard;
use Nova\Stories\Models\Post;
use Nova\Stories\Spotlight\ViewWritingDashboard;
use Nova\Stories\Spotlight\WritePost;
use Nova\Stories\View\Components\WritePostWizardLayout;
use Nova\Stories\Wizard\StepSynth;

class PostServiceProvider extends DomainServiceProvider
{
    public function bladeComponents(): array
    {
        return [
            'write-post-wizard-layout' => WritePostWizardLayout::class,
        ];
    }

    public function consoleCommands(): array
    {
        return [
            PruneAbandonedPosts::class,
        ];
    }

    public function domainBooted(): void
    {
        Livewire::propertySynthesizer(StepSynth::class);
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
            'posts-my-drafts-list' => MyDraftsList::class,
            'posts-list' => PostsList::class,
            'posts-timeline' => PostsTimeline::class,
            'posts-read-post-modal' => ReadPostModal::class,
            'posts-select-post-position-modal' => SelectPostPositionModal::class,
            'posts-write' => WritePostWizard::class,
            'posts-wizard-step-setup' => SetupPostStep::class,
            'posts-wizard-step-compose' => ComposePostStep::class,
            'posts-wizard-step-publish' => PublishPostStep::class,
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
