<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Nova\Applications\Actions\CreateApplication;
use Nova\Applications\Actions\CreateApplicationManager;
use Nova\Applications\Data\ApplicationData;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Events\ApplicationCreated;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Applications\Notifications\ApplicationReadyForReview;
use Nova\Characters\Models\Character;
use Nova\Discussions\Models\Discussion;
use Nova\Forms\Models\FormField;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\withoutExceptionHandling;

uses()->group('applications');

test('can create a basic application', function () {
    $user = User::factory()->pending()->create();
    $character = Character::factory()->pending()->create();

    $data = ApplicationData::from(
        user_id: $user->id,
        character_id: $character->id,
        ip_address: '127.0.0.1'
    );

    $application = CreateApplication::run($data);

    assertDatabaseHas(Application::class, [
        'id' => $application->id,
        'user_id' => $user->id,
        'character_id' => $character->id,
        'result' => ApplicationResult::Pending->value,
    ]);
});

test('new applications are pending by default', function () {
    withoutExceptionHandling();

    $user = User::factory()->pending()->create();
    $character = Character::factory()->pending()->create();

    $data = ApplicationData::from(
        user_id: $user->id,
        character_id: $character->id,
        ip_address: '127.0.0.1'
    );

    $application = CreateApplication::run($data);

    assertDatabaseHas(Application::class, [
        'id' => $application->id,
        'result' => 'pending',
    ]);
});

test('creating application dispatches event', function () {
    Event::fake();

    $user = User::factory()->pending()->create();
    $character = Character::factory()->pending()->create();

    $data = ApplicationData::from(
        user_id: $user->id,
        character_id: $character->id,
        ip_address: '127.0.0.1'
    );

    $application = CreateApplicationManager::run($data);

    Event::assertDispatched(ApplicationCreated::class, function ($event) use ($application) {
        return $event->application->id === $application->id;
    });
});

test('creating application creates discussion', function () {
    $user = User::factory()->pending()->create();
    $character = Character::factory()->pending()->create();

    $data = ApplicationData::from(
        user_id: $user->id,
        character_id: $character->id,
        ip_address: '127.0.0.1'
    );

    $application = CreateApplicationManager::run($data);

    expect($application->discussion)->toBeInstanceOf(Discussion::class);
});

test('creating application with form data creates form submission', function () {
    $user = User::factory()->pending()->create();
    $character = Character::factory()->pending()->create();

    $data = ApplicationData::from(
        user_id: $user->id,
        character_id: $character->id,
        ip_address: '127.0.0.1'
    );

    FormField::factory()->create(['uid' => 'field1']);

    $formData = ['field1' => 'value1'];
    $application = CreateApplicationManager::run($data, $formData);

    expect($application->applicationFormSubmission)->not->toBeNull();
});

describe('reviewer assignment', function () {
    test('assigns global reviewers to new application', function () {
        $globalReviewer = User::factory()->active()->create();

        ApplicationReviewer::factory()
            ->for($globalReviewer)
            ->global()
            ->create();

        $user = User::factory()->pending()->create();
        $character = Character::factory()->pending()->create();

        $data = ApplicationData::from(
            user_id: $user->id,
            character_id: $character->id,
            ip_address: '127.0.0.1'
        );

        $application = CreateApplicationManager::run($data);

        expect($application->reviews)->toHaveCount(1);
        expect($application->reviews->first()->id)->toBe($globalReviewer->id);
    });

    test('assigns users with application.approve permission to new applications', function () {
        $approver = createUser(permissions: 'application.approve');

        $user = User::factory()->pending()->create();
        $character = Character::factory()->pending()->create();

        $data = ApplicationData::from(
            user_id: $user->id,
            character_id: $character->id,
            ip_address: '127.0.0.1'
        );

        $application = CreateApplicationManager::run($data);

        expect($application->reviews->pluck('id'))->toContain($approver->id);
    });

    test('assigns both global reviewers and users with permission', function () {
        $globalReviewer = User::factory()->active()->create();

        ApplicationReviewer::factory()
            ->for($globalReviewer)
            ->global()
            ->create();

        $approver = createUser(permissions: 'application.approve');

        $user = User::factory()->pending()->create();
        $character = Character::factory()->pending()->create();

        $data = ApplicationData::from(
            user_id: $user->id,
            character_id: $character->id,
            ip_address: '127.0.0.1'
        );

        $application = CreateApplicationManager::run($data);

        expect($application->reviews)->toHaveCount(2);
        expect($application->reviews->pluck('id'))
            ->toContain($globalReviewer->id)
            ->toContain($approver->id);
    });

    test('does not duplicate reviewers if they are both global and have permission', function () {
        $reviewer = createUser(permissions: 'application.approve');

        ApplicationReviewer::factory()
            ->for($reviewer)
            ->global()
            ->create();

        $user = User::factory()->pending()->create();
        $character = Character::factory()->pending()->create();

        $data = ApplicationData::from(
            user_id: $user->id,
            character_id: $character->id,
            ip_address: '127.0.0.1'
        );

        $application = CreateApplicationManager::run($data);

        expect($application->reviews)->toHaveCount(1);
        expect($application->reviews->first()->id)->toBe($reviewer->id);
    });

    test('notifies assigned reviewers when application is created', function () {
        Notification::fake();

        $reviewer = createUser(permissions: 'application.approve');

        $user = User::factory()->create();
        $character = Character::factory()->create();

        $data = ApplicationData::from([
            'user_id' => $user->id,
            'character_id' => $character->id,
            'ip_address' => '127.0.0.1',
        ]);

        CreateApplicationManager::run($data);

        Notification::assertSentTo($reviewer, ApplicationReadyForReview::class);
    });

    test('does not assign inactive users as reviewers', function () {
        $inactiveReviewer = User::factory()->inactive()->create();

        ApplicationReviewer::factory()
            ->for($inactiveReviewer)
            ->global()
            ->create();

        $user = User::factory()->pending()->create();
        $character = Character::factory()->pending()->create();

        $data = ApplicationData::from(
            user_id: $user->id,
            character_id: $character->id,
            ip_address: '127.0.0.1'
        );

        $application = CreateApplicationManager::run($data);

        expect($application->reviews)->toHaveCount(0);
    });
});

describe('application relationships', function () {
    test('application belongs to user', function () {
        $user = User::factory()->pending()->create();
        $application = Application::factory()->for($user)->create();

        expect($application->user->id)->toBe($user->id);
    });

    test('application belongs to character', function () {
        $character = Character::factory()->pending()->create();
        $application = Application::factory()->for($character)->create();

        expect($application->character->id)->toBe($character->id);
    });

    test('application has many reviews', function () {
        $application = Application::factory()->create();
        $reviewer1 = User::factory()->active()->create();
        $reviewer2 = User::factory()->active()->create();

        $application->reviews()->attach([$reviewer1->id, $reviewer2->id]);

        expect($application->reviews)->toHaveCount(2);
    });
});
