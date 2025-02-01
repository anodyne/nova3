<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Applications\Actions\UpdateApplicationReview;
use Nova\Applications\Data\ApplicationReviewData;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Users\Models\User;

class ApplicationReviewForm extends Form
{
    #[Locked]
    public Application $application;

    #[Validate('required')]
    public ?ApplicationResult $result;

    public ApplicationReview $review;

    public ?string $comments = null;

    public function save(): void
    {
        $this->validate();

        UpdateApplicationReview::run(
            review: $this->review,
            data: ApplicationReviewData::from(
                result: $this->result,
                comments: $this->comments
            )
        );

        activity()
            ->performedOn($this->application)
            ->event('vote-'.$this->result->value)
            ->log('vote-'.$this->result->value);
    }

    public function setReview(Application $application, ApplicationReview $review, User $user): void
    {
        $this->application = $application;

        $this->review = $review;
        $this->result = $review->result;
        $this->comments = $review->comments;
    }
}
