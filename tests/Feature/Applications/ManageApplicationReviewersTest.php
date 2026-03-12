<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;
use Nova\Applications\Livewire\ApplicationReviewersModal;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Applications\Notifications\ApplicationReadyForReview;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses()->group('applications');

beforeEach(function () {
    $this->user1 = User::factory()->active()->create();
    $this->user2 = User::factory()->active()->create();

    $this->application = Application::factory()->pending()->create();
    $this->application->reviews()->attach([$this->user1, $this->user2]);
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('can manage reviewers for a pending application', function () {
        livewire(ApplicationReviewersModal::class, ['application' => $this->application])
            ->assertSuccessful()
            ->assertSet('selectedReviewers', [$this->user1->id, $this->user2->id]);
    });

    test('cannot manage reviewers for an accepted application', function () {
        $application = Application::factory()->accepted()->create();

        livewire(ApplicationReviewersModal::class, ['application' => $application])
            ->assertForbidden();
    });

    test('cannot manage reviewers for an denied application', function () {
        $application = Application::factory()->denied()->create();

        livewire(ApplicationReviewersModal::class, ['application' => $application])
            ->assertForbidden();
    });

    test('can add a reviewer to an application', function () {
        Notification::fake();

        $user = User::factory()->active()->create();

        livewire(ApplicationReviewersModal::class, ['application' => $this->application])
            ->set('selectedReviewers', [$this->user1->id, $this->user2->id, $user->id])
            ->assertSet('selectedReviewers', [$this->user1->id, $this->user2->id, $user->id])
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(ApplicationReview::class, [
            'application_id' => $this->application->id,
            'user_id' => $user->id,
        ]);

        Notification::assertSentTo($user, ApplicationReadyForReview::class);
        Notification::assertNotSentTo([$this->user1, $this->user2], ApplicationReadyForReview::class);
    });

    test('can remove a reviewer from an application', function () {
        livewire(ApplicationReviewersModal::class, ['application' => $this->application])
            ->set('selectedReviewers', [$this->user1->id])
            ->assertSet('selectedReviewers', [$this->user1->id])
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(ApplicationReview::class, [
            'application_id' => $this->application->id,
            'user_id' => $this->user1->id,
        ]);

        assertDatabaseMissing(ApplicationReview::class, [
            'application_id' => $this->application->id,
            'user_id' => $this->user2->id,
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot manage reviewers', function () {
        livewire(ApplicationReviewersModal::class, ['application' => $this->application])
            ->assertForbidden();
    });
});
