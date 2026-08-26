<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

class CreateFormSubmission
{
    use AsAction;

    /**
     * @param  array<string, mixed>|null  $meta
     */
    public function handle(Form $form, ?Model $owner, ?array $meta = null): FormSubmission
    {
        return DB::transaction(function () use ($form, $owner, $meta) {
            $formSubmission = $form->submissions()->create(['meta' => $meta]);

            $formSubmission->owner()->associate($owner)->save();

            return $formSubmission->refresh();
        });
    }
}
