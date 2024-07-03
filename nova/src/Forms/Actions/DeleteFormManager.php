<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

class DeleteFormManager
{
    use AsAction;

    public function handle(Form $form): Form
    {
        FormSubmission::query()
            ->form($form)
            ->get()
            ->each(fn (FormSubmission $submission) => DeleteFormSubmission::run($submission));

        $form->formFields()->delete();

        return tap($form)->delete();
    }
}
