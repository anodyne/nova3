<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\FormSubmission;
use Spatie\Activitylog\Facades\LogBatch;

class DeleteFormSubmission
{
    use AsAction;

    public function handle(FormSubmission $submission): FormSubmission
    {
        return DB::transaction(function () use ($submission) {
            LogBatch::startBatch();

            $submission->responses()->delete();

            $submission = tap($submission)->delete();

            LogBatch::endBatch();

            return $submission;
        });
    }
}
