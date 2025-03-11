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
        activity()->withoutLogs(function () use ($form) {
            $form->published_fields = $form->fields;
            $form->published_at = now();
            $form->save();
        });

        activity()
            ->performedOn($form)
            ->event('published')
            ->log('published');

        return $form->refresh();
    }
}
