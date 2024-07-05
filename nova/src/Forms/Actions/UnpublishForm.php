<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;

class UnpublishForm
{
    use AsAction;

    public function handle(Form $form): Form
    {
        $form->published_fields = null;
        $form->published_at = null;
        $form->save();

        return $form->refresh();
    }
}
