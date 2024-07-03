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
        $fieldUids = collect($form->published_fields['content'])
            ->flatMap(fn ($item) => [data_get($item, 'attrs.values.uid')])
            ->all();

        FormField::query()->whereNotIn('uid', $fieldUids)->delete();

        // Delete any submission data associated with the field(s)
    }
}
