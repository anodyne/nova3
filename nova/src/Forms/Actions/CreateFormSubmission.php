<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Spatie\Activitylog\Facades\LogBatch;

class CreateFormSubmission
{
    use AsAction;

    public function handle(Form $form, ?Model $owner, ?array $meta = null): FormSubmission
    {
        return DB::transaction(function () use ($form, $owner, $meta) {
            LogBatch::startBatch();

            $formSubmission = $form->submissions()->create(['meta' => $meta]);

            $formSubmission->owner()->associate($owner)->save();

            LogBatch::endBatch();

            return $formSubmission->refresh();
        });
    }
}
