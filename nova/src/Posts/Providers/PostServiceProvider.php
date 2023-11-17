<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Livewire\Livewire;
use Nova\DomainServiceProvider;
use Nova\Posts\Actions\PruneAbandonedPosts;
use Nova\Posts\Events\PostCreating;
use Nova\Posts\Listeners\SetDefaultContentRatings;
use Nova\Posts\Livewire\PostsList;
use Nova\Posts\Livewire\PostsTimeline;
use Nova\Posts\Livewire\ReadPostModal;
use Nova\Posts\Livewire\SelectPostPositionModal;
use Nova\Posts\Livewire\Steps\ComposePostStep;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Livewire\Steps\SetupPostStep;
use Nova\Posts\Livewire\WritePostWizard;
use Nova\Posts\Models\Post;
use Nova\Posts\Spotlight\WritePost;
use Nova\Posts\View\Components\WritePostWizardLayout;
use Nova\Posts\Wizard\StepSynth;

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
        ];
    }

    public function livewireComponents(): array
    {
        return [
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

    public function spotlightCommands(): array
    {
        return [
            WritePost::class,
        ];
    }
}
