<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;

class SyncDatabaseFormFields
{
    use AsAction;

    public function handle(Form $form): void
    {
        collect(data_get($form->published_fields, 'content') ?? [])
            ->reject(fn ($field) => $field['type'] !== 'scribbleBlock')
            ->each(function ($field, $key) use ($form) {
                FormField::updateOrCreate(
                    ['uid' => data_get($field, 'attrs.values.uid')],
                    [
                        'form_id' => $form->id,
                        'uid' => data_get($field, 'attrs.values.uid'),
                        'name' => data_get($field, 'attrs.values.name'),
                        'label' => data_get($field, 'attrs.values.label'),
                        'type' => data_get($field, 'attrs.identifier'),
                        'order_column' => $key,
                    ]
                );
            });
    }
}
