<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\Action;

class PublishForm extends Action
{
    public function handle(Form $form): Form
    {
        activity()->withoutLogging(function () use ($form): void {
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
