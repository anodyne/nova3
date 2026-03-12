<?php

declare(strict_types=1);

use Mchev\Banhammer\IP;
use Nova\Users\Actions\BanUser;
use Nova\Users\Livewire\BansList;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\withServerVariables;
use function Pest\Livewire\livewire;

uses()->group('bans');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'ban.create');
    });

    test('can view the manage bans page', function () {
        get(route('admin.bans.index'))
            ->assertSuccessful();

        livewire(BansList::class)
            ->assertSuccessful();
    });

    test('can filter by ban type', function () {
        $ipBan = Ban::factory()->forIpAddress()->create();

        $user = User::factory()->create();
        $userBan = Ban::factory()->forUser($user)->create();

        livewire(BansList::class)
            ->assertCanSeeTableRecords([$ipBan, $userBan])
            ->filterTable('ip', true)
            ->assertCanSeeTableRecords([$ipBan])
            ->assertCanNotSeeTableRecords([$userBan])
            ->resetTableFilters()
            ->filterTable('ip', false)
            ->assertCanSeeTableRecords([$userBan])
            ->assertCanNotSeeTableRecords([$ipBan]);
    });

    test('can filter by presence of expiration date', function () {
        $user1 = User::factory()->create();
        $user1Ban = Ban::factory()->forUser($user1)->expiresIn(2)->create();

        $user2 = User::factory()->create();
        $user2Ban = Ban::factory()->forUser($user2)->permanent()->create();

        livewire(BansList::class)
            ->assertCanSeeTableRecords([$user1Ban, $user2Ban])
            ->filterTable('hasExpiration', true)
            ->assertCanSeeTableRecords([$user1Ban])
            ->assertCanNotSeeTableRecords([$user2Ban])
            ->resetTableFilters()
            ->filterTable('hasExpiration', false)
            ->assertCanSeeTableRecords([$user2Ban])
            ->assertCanNotSeeTableRecords([$user1Ban]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

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

describe('prevents access', function () {
    test('by IP address', function () {
        $bannedIp = '192.168.1.100';
        IP::ban($bannedIp);

        withServerVariables([
            'REMOTE_ADDR' => $bannedIp,
        ])
            ->get('/')
            ->assertForbidden();
    });

    test('by user record', function () {
        $user = User::factory()->create();
        BanUser::run($user);

        test()
            ->actingAs($user)
            ->get('/')
            ->assertForbidden();
    });
});
