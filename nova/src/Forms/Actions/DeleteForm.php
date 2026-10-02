<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\Action;

class DeleteForm extends Action
{
    public function handle(Form $form): Form
    {
        return tap($form)->delete();
    }
}
