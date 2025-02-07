<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Foundation\WordGenerator;

class DuplicateForm
{
    use AsAction;

    public function handle(Form $original): Form
    {
        $form = activity()->withoutLogs(function () use ($original) {
            $form = $original->replicate(['prefixed_id']);

            $form->key = implode('-', (new WordGenerator)->words(2));
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
