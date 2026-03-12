<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;

use function Pest\Laravel\get;

uses()->group('forms', 'form-submissions');

beforeEach(function () {
    $this->form = Form::factory()->active()->basic()->create(['key' => 'test-form']);
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form-submission.view-all');

        $this->userSubmission = FormSubmission::factory()->create([
            'form_id' => $this->form->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);

        $this->otherSubmission = FormSubmission::factory()->create([
            'form_id' => $this->form->id,
        ]);
    });

    test('can view a form submission they submitted', function () {
        get(route('admin.form-submissions.show', $this->userSubmission))
            ->assertSuccessful();
    });

    test('can view a form submission they did not submit', function () {
        get(route('admin.form-submissions.show', $this->otherSubmission))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();

        $this->userSubmission = FormSubmission::factory()->create([
            'form_id' => $this->form->id,
            'owner_type' => 'user',
            'owner_id' => Auth::id(),
        ]);

        $this->otherSubmission = FormSubmission::factory()->create([
            'form_id' => $this->form->id,
        ]);
    });

    test('can view a form submission they submitted', function () {
        get(route('admin.form-submissions.show', $this->userSubmission))
            ->assertSuccessful();
    });

    test('cannot view a form submission they did not submit', function () {
        get(route('admin.form-submissions.show', $this->otherSubmission))
            ->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view a form submission', function () {
        $submission = FormSubmission::factory()->create([
            'form_id' => $this->form->id,
        ]);

        get(route('admin.form-submissions.show', $submission))
            ->assertRedirectToRoute('login');
    });
});
