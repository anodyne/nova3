<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\Action;

class UnpublishForm extends Action
{
    public function handle(Form $form): Form
    {
        activity()->withoutLogging(function () use ($form): void {
            $form->published_fields = null;
            $form->published_at = null;
            $form->save();
        });

        activity()
            ->performedOn($form)
            ->event('unpublished')
            ->log('unpublished');

        return $form->refresh();
    }
}
