<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Livewire\ApplicationsList;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('applications');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('can view the applications list page', function () {
        get(route('admin.applications.index'))->assertSuccessful();
    });

    test('can see all applications in the list', function () {
        $applications = Application::factory()->count(3)->create();

        livewire(ApplicationsList::class)
            ->assertSuccessful()
            ->assertCountTableRecords(3)
            ->assertCanSeeTableRecords($applications);
    });

    test('can filter applications by status', function () {
        $pending = Application::factory()->pending()->create();
        $accepted = Application::factory()->accepted()->create();
        $denied = Application::factory()->denied()->create();

        livewire(ApplicationsList::class)
            ->filterTable('result', ApplicationResult::Pending->value)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$pending])
            ->assertCanNotSeeTableRecords([$accepted, $denied])
            ->filterTable('result', ApplicationResult::Accept->value)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$accepted])
            ->assertCanNotSeeTableRecords([$pending, $denied])
            ->filterTable('result', ApplicationResult::Deny->value)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$denied])
            ->assertCanNotSeeTableRecords([$accepted, $pending]);
    });

    test('can search applications by applicant name', function () {
        $user = User::factory()->create(['name' => 'John Doe']);
        $application = Application::factory()->for($user)->create();

        Application::factory()->count(2)->create();

        livewire(ApplicationsList::class)
            ->searchTable('John Doe')
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$application]);
    });

    test('can search applications by character name', function () {
        $character = Character::factory()->create(['name' => 'Spock']);
        $application = Application::factory()->for($character)->create();

        Application::factory()->count(2)->create();

        livewire(ApplicationsList::class)
            ->searchTable('Spock')
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$application]);
    });

    test('shows empty state when no applications exist', function () {
        livewire(ApplicationsList::class)
            ->assertCountTableRecords(0);
    });
});

describe('assigned reviewer', function () {
    beforeEach(function () {
        signIn();
    });

    test('can view applications list page when assigned as reviewer', function () {
        $user = Auth::user();

        $application = Application::factory()->create();
        $application->reviews()->attach($user->id);

        get(route('admin.applications.index'))->assertSuccessful();
    });

    test('can only see applications they are reviewing', function () {
        $user = Auth::user();

        $application1 = Application::factory()->pending()->create();
        $application1->reviews()->attach($user->id);

        $application2 = Application::factory()->pending()->create();
        $application2->reviews()->attach($user->id);

        $applicationNotAssigned = Application::factory()->pending()->create();

        livewire(ApplicationsList::class)
            ->assertCanSeeTableRecords([$application1, $application2])
            ->assertCanNotSeeTableRecords([$applicationNotAssigned]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view applications list page', function () {
        get(route('admin.applications.index'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('is redirected to login', function () {
        get(route('admin.applications.index'))
            ->assertRedirectToRoute('login');
    });
});
