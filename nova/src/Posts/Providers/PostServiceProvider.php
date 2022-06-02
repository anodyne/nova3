<?php

declare(strict_types=1);

namespace Nova\Posts\Providers;

use Nova\DomainServiceProvider;
use Nova\Posts\Livewire\ComposePost;
use Nova\Posts\Livewire\ReadPostModal;
use Nova\Posts\Livewire\SelectDayModal;
use Nova\Posts\Livewire\SelectLocationModal;
use Nova\Posts\Livewire\SelectStoryModal;
use Nova\Posts\Livewire\SelectTimeModal;
use Nova\Posts\Livewire\SetContentRatingsModal;
use Nova\Posts\Livewire\Steps\ChoosePostTypeStep;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Livewire\Steps\WritePostStep;
use Nova\Posts\Livewire\WritePostWizard;
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

    public function livewireComponents(): array
    {
        return [
            'posts:compose' => ComposePost::class,
            'posts:read-post-modal' => ReadPostModal::class,
            'posts:select-day-modal' => SelectDayModal::class,
            'posts:select-location-modal' => SelectLocationModal::class,
            'posts:select-story-modal' => SelectStoryModal::class,
            'posts:select-time-modal' => SelectTimeModal::class,
            'posts:set-content-ratings-modal' => SetContentRatingsModal::class,
            'posts:write' => WritePostWizard::class,
            'posts:step:choose-post-type' => ChoosePostTypeStep::class,
            'posts:step:write-post' => WritePostStep::class,
            'posts:step:publish-post' => PublishPostStep::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            WritePost::class,
        ];
    }
}
