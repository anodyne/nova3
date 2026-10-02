<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Actions\Action;

class CreateFormSubmission extends Action
{
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
