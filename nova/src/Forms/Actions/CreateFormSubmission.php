<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Spatie\Activitylog\Facades\LogBatch;

class CreateFormSubmission
{
    use AsAction;

    public function handle(Form $form, mixed $owner, ?array $meta = null): FormSubmission
    {
        return DB::transaction(function () use ($form, $owner, $meta) {
            LogBatch::startBatch();

            $submission = $form->submissions()->create(['meta' => $meta]);

            $submission->owner()->associate($owner)->save();

            LogBatch::endBatch();

            return $submission->refresh();
        });
    }
}
