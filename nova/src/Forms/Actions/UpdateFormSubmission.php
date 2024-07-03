<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\FormSubmission;

class UpdateFormSubmission
{
    use AsAction;

    public function handle(FormSubmission $submission): FormSubmission
    {
        return tap($submission)
            ->update([])
            ->refresh();
    }
}
