<?php

declare(strict_types=1);

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Applications\Actions\AcceptApplicationManager;
use Nova\Applications\Actions\DenyApplicationManager;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Events\ApplicationAccepted;
use Nova\Applications\Events\ApplicationDenied;
use Nova\Applications\Livewire\ApplicationDecisionModal;
use Nova\Applications\Models\Application;
use Nova\Applications\Notifications\ApplicationAccepted as ApplicationAcceptedNotification;
use Nova\Applications\Notifications\ApplicationDenied as ApplicationDeniedNotification;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('applications');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('can access decision form for a pending application', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationDecisionModal::class, ['application' => $application])
            ->assertSuccessful();
    });

    test('can accept a pending application', function () {
        Event::fake();
        Notification::fake();

        $application = Application::factory()->pending()->create();
        $rank = RankItem::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome aboard!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);

        assertDatabaseHas(Application::class, [
            'id' => $application->id,
            'result' => ApplicationResult::Accept->value,
            'decision_message' => 'Welcome aboard!',
        ]);

        expect($application->fresh()->decision_date)->not->toBeNull();

        Event::assertDispatched(ApplicationAccepted::class, function ($event) use ($application) {
            return $event->application->id === $application->id;
        });
    });

    test('can deny a pending application', function () {
        Event::fake();
        Notification::fake();

        $application = Application::factory()->pending()->create();

        $data = ApplicationDecisionData::from(message: 'Not quite ready yet.');

        DenyApplicationManager::run($application, $data);

        assertDatabaseHas(Application::class, [
            'id' => $application->id,
            'result' => ApplicationResult::Deny->value,
            'decision_message' => 'Not quite ready yet.',
        ]);

        expect($application->fresh()->decision_date)->not->toBeNull();

        Event::assertDispatched(ApplicationDenied::class, function ($event) use ($application) {
            return $event->application->id === $application->id;
        });
    });

    test('cannot decide on already accepted application', function () {
        $application = Application::factory()->accepted()->create();

        livewire(ApplicationDecisionModal::class, ['application' => $application])
            ->assertForbidden();
    });

    test('cannot decide on already denied application', function () {
        $application = Application::factory()->denied()->create();

        livewire(ApplicationDecisionModal::class, ['application' => $application])
            ->assertForbidden();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot access decision form', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationDecisionModal::class, ['application' => $application])
            ->assertForbidden();
    });

    test('cannot accept application', function () {
        $application = Application::factory()->pending()->create();
        $rank = RankItem::factory()->create();

        $this->expectException(AuthorizationException::class);

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);
    });

    test('cannot deny application', function () {
        $application = Application::factory()->pending()->create();

        $this->expectException(AuthorizationException::class);

        $data = ApplicationDecisionData::from([
            'message' => 'Not approved.',
        ]);

        DenyApplicationManager::run($application, $data);
    });
});

describe('unauthenticated user', function () {
    test('cannot access decision form', function () {
        $application = Application::factory()->pending()->create();

        livewire(ApplicationDecisionModal::class, ['application' => $application])
            ->assertForbidden();
    });
});

describe('accepting application', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('notifies applicant', function () {
        Notification::fake();

        $user = User::factory()->create();
        $application = Application::factory()->for($user)->pending()->create();
        $rank = RankItem::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);

        Notification::assertSentTo($user, ApplicationAcceptedNotification::class);
    });

    test('activates user', function () {
        $user = User::factory()->inactive()->create();
        $application = Application::factory()->for($user)->pending()->create();
        $rank = RankItem::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);

        expect($user->fresh()->is_active)->toBeTrue();
    });

    test('activates character', function () {
        $character = Character::factory()->inactive()->create();
        $application = Application::factory()->for($character)->pending()->create();
        $rank = RankItem::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);

        expect($character->fresh()->is_active)->toBeTrue();
    });

    test('assigns rank to character', function () {
        $character = Character::factory()->create();
        $application = Application::factory()->for($character)->pending()->create();
        $rank = RankItem::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: []
        );

        AcceptApplicationManager::run($application, $data);

        expect($character->fresh()->rank_id)->toBe($rank->id);
    });

    test('assigns positions to character', function () {
        $character = Character::factory()->create();
        $application = Application::factory()->for($character)->pending()->create();
        $rank = RankItem::factory()->create();
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();

        $data = ApplicationDecisionData::from(
            message: 'Welcome!',
            rank_id: $rank->id,
            positions: [$position1->id, $position2->id]
        );

        AcceptApplicationManager::run($application, $data);

        expect($character->fresh()->positions)->toHaveCount(2);
        expect($character->fresh()->positions->pluck('id')->toArray())
            ->toContain($position1->id)
            ->toContain($position2->id);
    });
});

describe('denying application', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('notifies applicant', function () {
        Notification::fake();

        $user = User::factory()->create();
        $application = Application::factory()->for($user)->pending()->create();

        $data = ApplicationDecisionData::from(message: 'Not approved.');

        DenyApplicationManager::run($application, $data);

        Notification::assertSentTo($user, ApplicationDeniedNotification::class);
    });

    test('deactivates user', function () {
        $user = User::factory()->pending()->create();
        $application = Application::factory()->for($user)->pending()->create();

        $data = ApplicationDecisionData::from(message: 'Not approved.');

        DenyApplicationManager::run($application, $data);

        expect($user->fresh()->is_active)->toBeFalse();
        expect($user->fresh()->is_hidden)->toBeTrue();
    });

    test('deactivates character', function () {
        $character = Character::factory()->pending()->create();
        $application = Application::factory()->for($character)->pending()->create();

        $data = ApplicationDecisionData::from(message: 'Not approved');

        DenyApplicationManager::run($application, $data);

        expect($character->fresh()->is_active)->toBeFalse();
        expect($character->fresh()->is_hidden)->toBeTrue();
    });
});
