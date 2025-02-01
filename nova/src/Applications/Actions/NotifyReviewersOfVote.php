<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Applications\Notifications\ApplicationReviewerVotedToAccept;
use Nova\Applications\Notifications\ApplicationReviewerVotedToDeny;
use Nova\Users\Models\User;

class NotifyReviewersOfVote
{
    use AsAction;

    public function handle(Application $application, User $reviewer, ApplicationReview $review): void
    {
        $reviewers = $application->reviews;

        $notification = match ($review->result) {
            ApplicationResult::Accept => new ApplicationReviewerVotedToAccept($application, $reviewer, $review),
            ApplicationResult::Deny => new ApplicationReviewerVotedToDeny($application, $reviewer, $review),
            default => null
        };

        if (filled($notification)) {
            $reviewers
                ->reject(fn (User $user) => $user->id === $reviewer->id)
                ->each->notify($notification);
        }
    }
}
