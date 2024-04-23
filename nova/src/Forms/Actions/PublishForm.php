<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;

class PublishForm
{
    use AsAction;

    public function handle(Form $form): Form
    {
        $form->published_blocks = $form->blocks;
        $form->published_at = now();
        $form->save();

        return $form->refresh();
    }
}
