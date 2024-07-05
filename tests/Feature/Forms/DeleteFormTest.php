<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormDeleted;
use Nova\Forms\Livewire\FormsList;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('forms');

beforeEach(function () {
    $this->forms = Form::factory()
        ->count(10)
        ->has(FormField::factory(5), 'formFields')
        ->has(
            FormSubmission::factory(5)->has(FormSubmissionResponse::factory(5), 'responses'),
            'submissions'
        )
        ->create();

    signIn(permissions: 'form.delete');
});

test('an authorized user can delete a form', function () {
    Event::fake();

    $form = $this->forms->first()->load('formFields', 'submissions.responses');

    livewire(FormsList::class)
        ->callTableAction(DeleteAction::class, $form)
        ->assertCanNotSeeTableRecords([$form])
        ->assertNotified();

    assertDatabaseMissing(Form::class, $form->only('id', 'key', 'name'));

    assertDatabaseMissing(FormField::class, [
        'form_id' => $form->id,
    ]);

    assertDatabaseMissing(FormSubmission::class, [
        'form_id' => $form->id,
    ]);

    Event::assertDispatched(FormDeleted::class);
});

test('an authorized user can bulk delete forms', function () {
    $forms = $this->forms->take(3);

    livewire(FormsList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $forms)
        ->assertNotified();

    foreach ($forms as $form) {
        assertDatabaseMissing(Form::class, $form->toArray());

        assertDatabaseMissing(FormField::class, [
            'form_id' => $form->id,
        ]);

        assertDatabaseMissing(FormSubmission::class, [
            'form_id' => $form->id,
        ]);
    }
});
