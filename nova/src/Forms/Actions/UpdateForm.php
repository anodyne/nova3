<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Data\FormData;
use Nova\Forms\Data\FormFieldsData;
use Nova\Forms\Models\Form;

class UpdateForm
{
    use AsAction;

    public function handle(Form $form, FormData|FormFieldsData $data): Form
    {
        return tap($form)
            ->update(Arr::except($data->toArray(), ['key', 'type']))
            ->refresh();
    }
}
