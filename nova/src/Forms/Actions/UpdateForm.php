<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;

class UpdateForm
{
    use AsAction;

    public function handle(Form $form, FormData $data): Form
    {
        $form->update(
            $data->exceptWhen('key', $form->locked)->all()
        );

        return $form->refresh();
    }
}
