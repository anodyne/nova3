<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Users\Livewire\BansList;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('bans');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'ban.view'));

    test('can view the manage bans page', function () {
        get(route('admin.bans.index'))
            ->assertSuccessful();

        livewire(BansList::class)
            ->assertSuccessful();
    });

    test('can view a ban', function () {
        $user = User::factory()->create();

        $ban = Ban::factory()->forUser($user)->create();

        livewire(BansList::class)
            ->callAction(TestAction::make(ViewAction::class)->table($ban))
            ->assertSeeText($user->name);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage bans page', function () {
        get(route('admin.bans.index'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage bans page', function () {
        get(route('admin.bans.index'))
            ->assertRedirectToRoute('login');
    });
});
