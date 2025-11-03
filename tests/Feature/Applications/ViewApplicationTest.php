<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Applications\Livewire\ApplicationDiscussion;
use Nova\Applications\Livewire\ApplicationHistory;
use Nova\Applications\Models\Application;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('applications');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'application.approve');
    });

    test('can view an application', function () {
        $application = Application::factory()->create();

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('can view application info', function () {
        $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $application = Application::factory()->for($user)->create();

        get(route('admin.applications.show', $application))
            ->assertViewHas('application', $application)
            ->assertSeeText($user->name)
            ->assertSeeText($user->email);
    });

    test('can view application discussion', function () {
        $application = Application::factory()->create();

        livewire(ApplicationDiscussion::class, ['application' => $application])
            ->assertSuccessful();
    });

    test('can view application history', function () {
        $application = Application::factory()->create();

        livewire(ApplicationHistory::class, ['application' => $application])
            ->assertSuccessful();
    });

    test('can view pending application', function () {
        $application = Application::factory()->pending()->create();

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('can view accepted application', function () {
        $application = Application::factory()->accepted()->create();

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('can view denied application', function () {
        $application = Application::factory()->denied()->create();

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });
});

describe('assigned reviewer', function () {
    beforeEach(function () {
        signIn();
    });

    test('can view pending application they were assigned to review', function () {
        $user = Auth::user();
        $application = Application::factory()->pending()->create();
        $application->reviews()->attach($user->id);

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('can view accepted application they were assigned to review', function () {
        $user = Auth::user();
        $application = Application::factory()->accepted()->create();
        $application->reviews()->attach($user->id);

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('can view denied application they were assigned to review', function () {
        $user = Auth::user();
        $application = Application::factory()->denied()->create();
        $application->reviews()->attach($user->id);

        get(route('admin.applications.show', $application))
            ->assertSuccessful();
    });

    test('cannot view application they were not assigned to review', function () {
        $application = Application::factory()->create();

        get(route('admin.applications.show', $application))
            ->assertForbidden();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view application detail page', function () {
        $application = Application::factory()->create();

        get(route('admin.applications.show', $application))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('is redirected to login when viewing application', function () {
        $application = Application::factory()->create();

        get(route('admin.applications.show', $application))
            ->assertRedirectToRoute('login');
    });
});
