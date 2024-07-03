<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

class CreateFormSubmission
{
    use AsAction;

    public function handle(Form $form, mixed $owner): FormSubmission
    {
        $submission = $form->submissions()->create([]);

        $submission->owner()->associate($owner)->save();

        return $submission->refresh();
    }
}
