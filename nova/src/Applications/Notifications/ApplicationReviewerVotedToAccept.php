<?php

declare(strict_types=1);

namespace Nova\Applications\Notifications;

use Illuminate\Mail\Mailable;
use Nova\Applications\Mail\SendReviewerVotedToAcceptMail;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Models\User;

class ApplicationReviewerVotedToAccept extends PreferenceBasedNotification
{
    protected string $key = 'application-reviewer-voted-to-accept';

    public function __construct(
        protected Application $application,
        protected User $reviewer,
        protected ApplicationReview $review
    ) {}

    public function toArray(object $notifiable): array
    {
        $this->application->load('character');

        return [
            'application_id' => $this->application->id,
            'reviewer_name' => $this->reviewer->name,
            'character_name' => $this->application->character->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendReviewerVotedToAcceptMail(
            application: $this->application,
            reviewer: $this->reviewer,
            review: $this->review
        );
    }
}
