<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
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
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms');

beforeEach(function () {
    $this->forms = Form::factory()
        ->count(3)
        ->has(FormField::factory(5), 'formFields')
        ->has(
            FormSubmission::factory(5)->has(FormSubmissionResponse::factory(5), 'responses'),
            'submissions'
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'form.delete'));

    test('can delete a form', function () {
        Event::fake();

        $form = $this->forms->first()->load('formFields', 'submissions.responses');

        livewire(FormsList::class)
            ->assertCanSeeTableRecords([$form])
            ->callAction(TestAction::make(DeleteAction::class)->table($form))
            ->assertCanNotSeeTableRecords([$form])
            ->assertNotified();

        assertDatabaseMissing(Form::class, $form->only('id'));

        assertDatabaseMissing(FormField::class, [
            'form_id' => $form->id,
        ]);

        assertDatabaseMissing(FormSubmission::class, [
            'form_id' => $form->id,
        ]);

        Event::assertDispatched(FormDeleted::class);
    });

    test('can bulk delete forms', function () {
        $forms = $this->forms->take(3);

        livewire(FormsList::class)
            ->assertCanSeeTableRecords($forms)
            ->selectTableRecords($forms)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords($forms)
            ->assertNotified();

        foreach ($forms as $form) {
            assertDatabaseMissing(Form::class, $form->only('id'));

            assertDatabaseMissing(FormField::class, [
                'form_id' => $form->id,
            ]);

            assertDatabaseMissing(FormSubmission::class, [
                'form_id' => $form->id,
            ]);
        }
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete forms', function () {
        get(route('admin.forms.index'))
            ->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete forms', function () {
        get(route('admin.forms.index'))
            ->assertRedirectToRoute('login');
    });
});
