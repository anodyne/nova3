<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationReviewData;
use Nova\Applications\Models\ApplicationReview;

class UpdateApplicationReview
{
    use AsAction;

    public function handle(ApplicationReview $review, ApplicationReviewData $data): ApplicationReview
    {
        $review = tap($review)
            ->update($data->toArray())
            ->refresh();

        NotifyReviewersOfVote::run(
            application: $review->application,
            reviewer: $review->user,
            review: $review
        );

        return $review;
    }
}
