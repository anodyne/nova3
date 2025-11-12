<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Livewire\DynamicForm;
use Nova\Forms\Mail\SendNewFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmissionResponse;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\withoutExceptionHandling;
use function Pest\Livewire\livewire;

uses()->group('forms', 'form-submissions');

beforeEach(function () {
    $this->basicForm1 = Form::factory()
        ->active()
        ->basic()
        ->create([
            'key' => 'test-basic-form-1',
            'options' => [
                'onlyAuthenticatedUsers' => true,
                'collectResponses' => true,
                'singleSubmission' => false,
                'submissionTitleField' => null,
                'emailResponses' => false,
                'emailRecipients' => null,
            ],
            'fields' => [
                [
                    'type' => 'short-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_fields' => [
                [
                    'type' => 'short-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
    SyncDatabaseFormFields::run($this->basicForm1);

    $this->basicForm2 = Form::factory()
        ->active()
        ->basic()
        ->create([
            'key' => 'test-basic-form-2',
            'options' => [
                'onlyAuthenticatedUsers' => true,
                'collectResponses' => true,
                'singleSubmission' => false,
                'submissionTitleField' => null,
                'emailResponses' => true,
                'emailRecipients' => 'test@example.test',
            ],
            'fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => true,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'QFbGHpgbPbT1',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_fields' => [
                [
                    'type' => 'short-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => true,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
    SyncDatabaseFormFields::run($this->basicForm2);

    $this->basicForm3 = Form::factory()
        ->inactive()
        ->basic()
        ->create([
            'key' => 'test-basic-form-3',
            'options' => [
                'onlyAuthenticatedUsers' => true,
                'collectResponses' => true,
                'singleSubmission' => false,
                'submissionTitleField' => null,
                'emailResponses' => false,
                'emailRecipients' => null,
            ],
        ]);

    $this->advancedForm = Form::factory()->active()->advanced()->create(['key' => 'test-advanced-form']);
});

describe('authenticated user', function () {
    beforeEach(fn () => signIn());

    test('can view the create form submission page', function () {
        get(route('admin.form-submissions.create'))
            ->assertSuccessful()
            ->assertSeeText($this->basicForm1->name)
            ->assertSeeText($this->basicForm2->name)
            ->assertDontSeeText($this->basicForm3->name)
            ->assertDontSeeText($this->advancedForm->name);
    });

    test('can view the create form submission page for a specific form', function () {
        get(route('admin.form-submissions.create', $this->basicForm1))
            ->assertSuccessful()
            ->assertSeeText($this->basicForm1->name)
            ->assertDontSeeText($this->basicForm2->name)
            ->assertDontSeeText($this->basicForm3->name);
    });

    test('cannot view the create form submission page for an inactive form', function () {
        get(route('admin.form-submissions.create', $this->basicForm3))
            ->assertNotFound();
    });

    test('can see published fields on a form', function () {
        get(route('admin.form-submissions.create', $this->basicForm1))
            ->assertSuccessful()
            ->assertSeeHtml('id="pVrlCJv8bDDw"');
    });

    test('cannot see unpublished fields on a form', function () {
        get(route('admin.form-submissions.create', $this->basicForm1))
            ->assertSuccessful()
            ->assertSeeHtml('id="pVrlCJv8bDDw"')
            ->assertDontSeeHtml('id="QFbGHpgbPbT1"');
    });

    test('can submit a form', function () {
        livewire(DynamicForm::class, ['form' => $this->basicForm1, 'owner' => Auth::user(), 'admin' => true])
            ->assertSet('form', $this->basicForm1)
            ->assertSet('owner', Auth::user())
            ->assertSet('admin', true)
            ->fill([
                'values.pVrlCJv8bDDw' => 'Foo',
            ])
            ->call('submit')
            ->assertNotified();

        assertDatabaseHas(FormSubmissionResponse::class, [
            'field_uid' => 'pVrlCJv8bDDw',
            'value' => 'Foo',
        ]);
    });

    test('cannot submit a form if it fails validation', function () {
        withoutExceptionHandling();

        livewire(DynamicForm::class, ['form' => $this->basicForm2, 'owner' => Auth::user(), 'admin' => true])
            ->assertSet('form', $this->basicForm2)
            ->assertSet('owner', Auth::user())
            ->assertSet('admin', true)
            ->fill([
                'values.pVrlCJv8bDDw' => '',
            ])
            ->call('submit')
            ->assertHasErrors(['values.pVrlCJv8bDDw' => 'required']);

        assertDatabaseMissing(FormSubmissionResponse::class, [
            'field_uid' => 'pVrlCJv8bDDw',
        ]);
    });

    test('can email responses if enabled', function () {
        Mail::fake();

        livewire(DynamicForm::class, ['form' => $this->basicForm2, 'owner' => Auth::user(), 'admin' => true])
            ->assertSet('form', $this->basicForm2)
            ->assertSet('owner', Auth::user())
            ->assertSet('admin', true)
            ->fill([
                'values.pVrlCJv8bDDw' => 'Foo',
            ])
            ->call('submit');

        Mail::assertQueued(SendNewFormSubmission::class);
        Mail::assertQueuedCount(1);
    });

    test('does not email responses if disabled', function () {
        Mail::fake();

        livewire(DynamicForm::class, ['form' => $this->basicForm1, 'owner' => Auth::user(), 'admin' => true])
            ->assertSet('form', $this->basicForm1)
            ->assertSet('owner', Auth::user())
            ->assertSet('admin', true)
            ->fill([
                'values.pVrlCJv8bDDw' => 'Foo',
            ])
            ->call('submit');

        Mail::assertNothingSent();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create form submission page', function () {
        get(route('admin.form-submissions.create'))
            ->assertRedirectToRoute('login');
    });
});
