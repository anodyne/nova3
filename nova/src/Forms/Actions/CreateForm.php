<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\Action;

class CreateForm extends Action
{
    public function handle(FormData $data): Form
    {
        return Form::create($data->toArray());
    }
}
