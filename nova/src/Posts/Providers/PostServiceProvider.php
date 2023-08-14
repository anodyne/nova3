<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Actions\PruneAbandonedPosts;
use Nova\Posts\Events\PostCreating;
use Nova\Posts\Listeners\SetDefaultContentRatings;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\ManageAuthorsModal;
use Nova\Posts\Livewire\ReadPostModal;
use Nova\Posts\Livewire\SelectCharacterAuthorsModal;
use Nova\Posts\Livewire\SelectDayModal;
use Nova\Posts\Livewire\SelectLocationModal;
use Nova\Posts\Livewire\SelectPostPositionModal;
use Nova\Posts\Livewire\SelectStoryModal;
use Nova\Posts\Livewire\SelectTimeModal;
use Nova\Posts\Livewire\SelectUserAuthorsModal;
use Nova\Posts\Livewire\SetContentRatingsModal;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Livewire\Steps\SelectAuthorsStep;
use Nova\Posts\Livewire\Steps\SetupPostStep;
use Nova\Posts\Livewire\Steps\WritePostStep;
use Nova\Posts\Livewire\WritePostWizard;
use Nova\Posts\Models\Post;
use Nova\Posts\Spotlight\WritePost;
use Nova\Posts\View\Components\WritePostWizardLayout;

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
            'posts:compose' => ComposePost::class,
            'posts:read-post-modal' => ReadPostModal::class,
            'posts:manage-authors-modal' => ManageAuthorsModal::class,
            'posts:select-character-authors-modal' => SelectCharacterAuthorsModal::class,
            'posts:select-user-authors-modal' => SelectUserAuthorsModal::class,
            'posts:select-day-modal' => SelectDayModal::class,
            'posts:select-location-modal' => SelectLocationModal::class,
            'posts:select-story-modal' => SelectStoryModal::class,
            'posts:select-post-position-modal' => SelectPostPositionModal::class,
            'posts:select-time-modal' => SelectTimeModal::class,
            'posts:set-content-ratings-modal' => SetContentRatingsModal::class,
            'posts:write' => WritePostWizard::class,
            'posts:step:setup-post' => SetupPostStep::class,
            'posts:step:select-authors' => SelectAuthorsStep::class,
            'posts:step:write-post' => WritePostStep::class,
            'posts:step:publish-post' => PublishPostStep::class,
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
