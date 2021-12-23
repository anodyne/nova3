<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;

class UpdateForm
{
    use AsAction;

    public function handle(Form $form, FormData $data): Form
    {
        $updateData = ($form->locked)
            ? Arr::except($data->all(), 'key')
            : $data->all();

        $form->update($updateData);

        return $form->refresh();
    }
}
