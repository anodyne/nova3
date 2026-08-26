<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use NicoBleiler\Passphrase\Facades\Passphrase;
use Nova\Forms\Models\Form;

class DuplicateForm
{
    use AsAction;

    public function handle(Form $original): Form
    {
        $form = activity()->withoutLogging(function () use ($original) {
            $form = $original->replicate(['prefixed_id']);
            $form->key = Passphrase::generate();
            $form->name = "Copy of {$form->name}";

            $form->save();

            return $form;
        });

        activity()
            ->performedOn($original)
            ->withProperty('replica', $form->id)
            ->event('duplicated')
            ->log('duplicated');

        return $form->refresh();
    }
}
