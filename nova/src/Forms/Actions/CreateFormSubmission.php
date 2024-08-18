<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

class CreateFormSubmission
{
    use AsAction;

    public function handle(Form $form, mixed $owner, ?array $meta = null): FormSubmission
    {
        $submission = $form->submissions()->create(['meta' => $meta]);

        $submission->owner()->associate($owner)->save();

        return $submission->refresh();
    }
}
