<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\FormSubmission;

class DeleteFormSubmission
{
    use AsAction;

    public function handle(FormSubmission $submission): FormSubmission
    {
        return DB::transaction(function () use ($submission) {
            $submission->responses()->delete();

            $submission = tap($submission)->delete();

            return $submission;
        });
    }
}
