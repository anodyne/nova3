<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Forms\Livewire\FormSubmissionsList;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms', 'form-submissions');

beforeEach(function () {
    $this->form = Form::factory()->basic()->create();

    $this->submission = FormSubmission::factory()->create(['form_id' => $this->form->id]);
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'form-submission.delete'));

    test('can delete a form submission', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanSeeTableRecords([$this->submission])
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($this->submission))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($this->submission))
            ->callAction(TestAction::make(DeleteAction::class)->table($this->submission))
            ->assertNotified();

        assertDatabaseMissing(FormSubmission::class, [
            'id' => $this->submission->id,
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete a form submission', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanNotSeeTableRecords([$this->submission]);
    });
});

describe('unauthenticated user', function () {
    test('cannot delete a form submission', function () {
        get(route('admin.form-submissions.index'))
            ->assertRedirectToRoute('login');
    });
});
