<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;

class RemoveDeletedFormFields
{
    use AsAction;

    public function handle(Form $form): void
    {
        $fieldUids = collect($form->published_fields ?? [])
            ->flatMap(fn ($item) => [data_get($item, 'data.attrs.id')])
            ->toArray();

        FormField::query()->form($form)->whereNotIn('uid', $fieldUids)->delete();

        // Delete any submission data associated with the field(s)
    }
}
