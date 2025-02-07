<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Spatie\Activitylog\Facades\LogBatch;

class DeleteFormManager
{
    use AsAction;

    public function handle(Form $form): Form
    {
        return DB::transaction(function () use ($form) {
            LogBatch::startBatch();

            FormSubmission::query()
                ->form($form)
                ->get()
                ->each(fn (FormSubmission $submission) => DeleteFormSubmission::run($submission));

            $form->formFields()->delete();

            $form = DeleteForm::run($form);

            LogBatch::endBatch();

            return $form;
        });
    }
}
