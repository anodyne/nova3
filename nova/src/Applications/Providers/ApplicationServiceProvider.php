<?php

declare(strict_types=1);

namespace Nova\Applications\Providers;

use Nova\Applications\Livewire\ApplicationDecisionModal;
use Nova\Applications\Livewire\ApplicationDiscussion;
use Nova\Applications\Livewire\ApplicationHistory;
use Nova\Applications\Livewire\ApplicationReview;
use Nova\Applications\Livewire\ApplicationReviewersModal;
use Nova\Applications\Livewire\ApplicationReviewModal;
use Nova\Applications\Livewire\ApplicationsList;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview as ApplicationReviewModel;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\DomainServiceProvider;

class ApplicationServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'application-decision-modal' => ApplicationDecisionModal::class,
            'application-discussion' => ApplicationDiscussion::class,
            'application-history' => ApplicationHistory::class,
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
            'application-review' => ApplicationReviewModel::class,
            'application-reviewer' => ApplicationReviewer::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'app_' => Application::class,
        ];
    }
}
