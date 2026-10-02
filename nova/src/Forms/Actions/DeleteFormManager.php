<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Actions\Action;

class DeleteFormManager extends Action
{
    public function handle(Form $form): Form
    {
        return DB::transaction(function () use ($form) {
            FormSubmission::query()
                ->forForm($form)
                ->get()
                ->each(fn (FormSubmission $submission): mixed => DeleteFormSubmission::run($submission));

            $form->formFields()->delete();

            $form = DeleteForm::run($form);

            return $form;
        });
    }
}
