<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Nova\Forms\Livewire\FormSubmissionsList;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\ViewAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms', 'form-submissions');

beforeEach(function () {
    $this->basicForm = Form::factory()->basic()->create(['key' => 'test-basic-form']);
    $this->advancedForm = Form::factory()->advanced()->create(['key' => 'test-advanced-form']);
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form-submission.view-all');

        $this->userSubmission = FormSubmission::factory()->create([
            'form_id' => $this->basicForm->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);

        $this->otherSubmission = FormSubmission::factory()->create([
            'form_id' => $this->basicForm->id,
        ]);

        $this->advancedSubmission = FormSubmission::factory()->create([
            'form_id' => $this->advancedForm->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);
    });

    test('can view the list form submissions page', function () {
        get(route('admin.form-submissions.index'))
            ->assertSuccessful();
    });

    test('can see submissions they created', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanSeeTableRecords([$this->userSubmission])
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($this->userSubmission))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->userSubmission));
    });

    test('can see submissions they did not create', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanSeeTableRecords([$this->otherSubmission])
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($this->userSubmission))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->userSubmission));
    });

    test('cannot not see submissions on an advanced form', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanNotSeeTableRecords([$this->advancedSubmission]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();

        $this->userSubmission = FormSubmission::factory()->create([
            'form_id' => $this->basicForm->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);

        $this->otherSubmission = FormSubmission::factory()->create([
            'form_id' => $this->basicForm->id,
        ]);

        $this->advancedSubmission = FormSubmission::factory()->create([
            'form_id' => $this->advancedForm->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);
    });

    test('can view the list form submissions page', function () {
        get(route('admin.form-submissions.index'))
            ->assertSuccessful();
    });

    test('can see submissions they created on a basic form', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanSeeTableRecords([$this->userSubmission])
            ->assertActionVisible(TestAction::make(ViewAction::class)->table($this->userSubmission))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($this->userSubmission));
    });

    test('cannot not see submissions they did not create on a basic form', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanNotSeeTableRecords([$this->otherSubmission]);
    });

    test('cannot not see submissions on an advanced form', function () {
        livewire(FormSubmissionsList::class)
            ->assertCanNotSeeTableRecords([$this->advancedSubmission]);
    });
});

describe('unauthenticated user', function () {
    test('cannot view the list form submissions page', function () {
        get(route('admin.form-submissions.index'))
            ->assertRedirectToRoute('login');
    });
});
