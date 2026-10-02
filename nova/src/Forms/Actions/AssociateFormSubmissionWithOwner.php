<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Actions\Action;

class AssociateFormSubmissionWithOwner extends Action
{
    public function handle(FormSubmission $submission, mixed $owner): FormSubmission
    {
        $submission->owner()->associate($owner)->save();

        return $submission->refresh();
    }
}
