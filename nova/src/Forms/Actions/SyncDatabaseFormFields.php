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
        collect($form->published_fields ?? [])
            ->reject(fn ($field): bool => data_get($field, 'type') === 'content')
            ->each(function ($field, $key) use ($form): void {
                FormField::updateOrCreate(
                    ['uid' => data_get($field, 'data.attrs.id')],
                    [
                        'form_id' => $form->id,
                        'uid' => data_get($field, 'data.attrs.id'),
                        'name' => data_get($field, 'data.attrs.name'),
                        'label' => data_get($field, 'data.details.label'),
                        'type' => data_get($field, 'type'),
                        'order_column' => $key,
                    ]
                );
            });
    }
}
