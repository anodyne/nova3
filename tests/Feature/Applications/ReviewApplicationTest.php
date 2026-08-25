<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Livewire\ApplicationReview;
use Nova\Applications\Livewire\ApplicationReviewModal;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview as ApplicationReviewModel;
use Nova\Applications\Notifications\ApplicationReviewerVotedToAccept;
use Nova\Applications\Notifications\ApplicationReviewerVotedToDeny;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('applications');

describe('authorized reviewer', function () {
    beforeEach(function () {
        signIn();

        $this->application = Application::factory()->pending()->create();
        $this->application->reviews()->attach(Auth::id());
    });

    test('can view their review status', function () {
        livewire(ApplicationReview::class, ['application' => $this->application])
            ->assertSuccessful();
    });

    test('can submit a vote to accept', function () {
        Event::fake();
        Notification::fake();

        livewire(ApplicationReviewModal::class, ['application' => $this->application->id, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Accept)
            ->assertSet('form.result', ApplicationResult::Accept)
            ->set('form.comments', 'Great application!')
            ->assertSet('form.comments', 'Great application!')
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(ApplicationReviewModel::class, [
            'application_id' => $this->application->id,
            'user_id' => Auth::id(),
            'result' => ApplicationResult::Accept->value,
            'comments' => 'Great application!',
        ]);
    });

    test('can submit a vote to deny', function () {
        Event::fake();
        Notification::fake();

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Deny)
            ->assertSet('form.result', ApplicationResult::Deny)
            ->set('form.comments', 'Needs improvement')
            ->assertSet('form.comments', 'Needs improvement')
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(ApplicationReviewModel::class, [
            'application_id' => $this->application->id,
            'user_id' => Auth::id(),
            'result' => ApplicationResult::Deny->value,
            'comments' => 'Needs improvement',
        ]);
    });

    test('notifies other reviewers when voting to accept', function () {
        Notification::fake();

        $otherReviewer = User::factory()->create();
        $this->application->reviews()->attach($otherReviewer->id);

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Accept)
            ->set('form.comments', 'Great application!')
            ->call('save');

        Notification::assertSentTo($otherReviewer, ApplicationReviewerVotedToAccept::class);
        Notification::assertNotSentTo(Auth::user(), ApplicationReviewerVotedToAccept::class);
    });

    test('notifies other reviewers when voting to deny', function () {
        Notification::fake();

        $otherReviewer = User::factory()->create();
        $this->application->reviews()->attach($otherReviewer->id);

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Deny)
            ->set('form.comments', 'Needs improvement')
            ->call('save');

        Notification::assertSentTo($otherReviewer, ApplicationReviewerVotedToDeny::class);
        Notification::assertNotSentTo(Auth::user(), ApplicationReviewerVotedToDeny::class);
    });

    test('can update their vote if allowed by settings', function () {
        updateSettings(function ($settings) {
            $settings->applications = $settings->applications->with(allowVoteChanging: true);

            return $settings;
        });

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Accept)
            ->set('form.comments', 'Initial vote')
            ->call('save');

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Deny)
            ->set('form.comments', 'Changed my mind')
            ->call('save');

        assertDatabaseHas(ApplicationReviewModel::class, [
            'application_id' => $this->application->id,
            'user_id' => Auth::id(),
            'result' => ApplicationResult::Deny->value,
            'comments' => 'Changed my mind',
        ]);
    });

    test('cannot update their vote if disallowed by settings', function () {
        updateSettings(function ($settings) {
            $settings->applications = $settings->applications->with(allowVoteChanging: false);

            return $settings;
        });

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Accept)
            ->set('form.comments', 'Initial vote')
            ->call('save');

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->assertForbidden();

        assertDatabaseHas(ApplicationReviewModel::class, [
            'application_id' => $this->application->id,
            'user_id' => Auth::id(),
            'result' => ApplicationResult::Accept->value,
            'comments' => 'Initial vote',
        ]);
    });

    test('can include review form submission', function () {
        $form = Form::key('applicationReview')->first();

        $fieldKey = $form->formFields->first()->uid;

        livewire(ApplicationReviewModal::class, ['application' => $this->application, 'user' => Auth::id()])
            ->set('form.result', ApplicationResult::Accept)
            ->set('form.comments', 'Great!')
            ->set('form.values', [
                $fieldKey => 'foo',
            ])
            ->assertSet('form.values', [
                $fieldKey => 'foo',
            ])
            ->call('save');

        $submission = FormSubmission::latest()->first();

        assertDatabaseHas(FormSubmission::class, [
            'id' => $submission->id,
            'form_id' => $form->id,
            'owner_id' => Auth::id(),
            'owner_type' => 'user',
        ]);

        assertDatabaseHas(FormSubmissionResponse::class, [
            'submission_id' => $submission->id,
        ]);
    });
});

describe('authorized reviewer on decided application', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot vote on accepted application', function () {
        $application = Application::factory()->accepted()->create();
        $application->reviews()->attach(Auth::id());

        livewire(ApplicationReviewModal::class, ['application' => $application, 'user' => Auth::id()])
            ->assertForbidden();
    });

    test('cannot vote on denied application', function () {
        $application = Application::factory()->denied()->create();
        $application->reviews()->attach(Auth::id());

        livewire(ApplicationReviewModal::class, ['application' => $application, 'user' => Auth::id()])
            ->assertForbidden();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot review application they are not assigned to', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationReviewModal::class, ['application' => $application, 'user' => Auth::id()])
            ->assertForbidden();
    });

    test('cannot view review status for unassigned application', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationReviewModal::class, ['application' => $application, 'user' => Auth::id()])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot access review form', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationReviewModal::class, ['application' => $application])
            ->assertForbidden();
    });
});
