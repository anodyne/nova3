<?php

declare(strict_types=1);

namespace Nova\Applications\Providers;

use Nova\Applications\Livewire\ApplicationDecisionModal;
use Nova\Applications\Livewire\ApplicationDiscussion;
use Nova\Applications\Livewire\ApplicationReview;
use Nova\Applications\Livewire\ApplicationReviewersModal;
use Nova\Applications\Livewire\ApplicationReviewModal;
use Nova\Applications\Livewire\ApplicationsList;
use Nova\Applications\Models\Application;
use Nova\DomainServiceProvider;

class ApplicationServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'application-decision-modal' => ApplicationDecisionModal::class,
            'application-discussion' => ApplicationDiscussion::class,
            'application-review' => ApplicationReview::class,
            'application-review-modal' => ApplicationReviewModal::class,
            'application-reviewers-modal' => ApplicationReviewersModal::class,
            'applications-list' => ApplicationsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'application' => Application::class,
        ];
    }
}
