<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview as ApplicationReviewModel;

#[On('review-submitted')]
#[On('reviewers-updated')]
class ApplicationReview extends Component
{
    public Application $application;

    #[Computed]
    public function currentUserHasReviewed(): bool
    {
        $review = ApplicationReviewModel::query()
            ->where('application_id', $this->application->id)
            ->where('user_id', Auth::id())
            ->first();

        return filled($review->result);
    }

    public function hydrate()
    {
        $this->application->loadCount('reviews', 'acceptedReviews', 'deniedReviews', 'noResultReviews');
    }

    public function render()
    {
        return view('pages.applications.livewire.review', [
            'currentUserHasReviewed' => $this->currentUserHasReviewed,
        ]);
    }
}
