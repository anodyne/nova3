<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;

class DeleteForm
{
    use AsAction;

    public function handle(Form $form): Form
    {
        return tap($form)->delete();
    }
}
