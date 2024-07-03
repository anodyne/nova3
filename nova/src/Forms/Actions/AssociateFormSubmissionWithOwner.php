<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\FormSubmission;

class AssociateFormSubmissionWithOwner
{
    use AsAction;

    public function handle(FormSubmission $submission, mixed $owner): FormSubmission
    {
        $submission->owner()->associate($owner)->save();

        return $submission->refresh();
    }
}
