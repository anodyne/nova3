<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;

class PublishFormManager
{
    use AsAction;

    public function handle(Form $form): Form
    {
        // Create/update fields in the database

        // Delete any fields that have been removed
        // Cleanup any submission data of deleted fields

        $form = PublishForm::run($form);

        SyncDatabaseFormFields::run($form);

        RemoveDeletedFormFields::run($form);

        return $form->refresh();
    }
}
