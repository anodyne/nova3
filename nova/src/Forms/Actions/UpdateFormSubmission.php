<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Actions\Action;

class UpdateFormSubmission extends Action
{
    public function handle(FormSubmission $submission): FormSubmission
    {
        return tap($submission)
            ->update([])
            ->refresh();
    }
}
