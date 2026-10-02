<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Arr;
use Nova\Forms\Data\FormData;
use Nova\Forms\Data\FormFieldsData;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\Action;

class UpdateForm extends Action
{
    public function handle(Form $form, FormData|FormFieldsData $data): Form
    {
        return tap($form)
            ->update(Arr::except($data->toArray(), ['key', 'type']))
            ->refresh();
    }
}
