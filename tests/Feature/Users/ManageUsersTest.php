<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Stories\Models\Post;
use Nova\Users\Livewire\UsersList;
use Nova\Users\Models\Login;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('users');

describe('authorized user', function () {
    beforeEach(function () {
        $this->tableScope = 'manage-users-'.str()->random(8);

        signIn(permissions: 'user.create');

        $this->users = User::factory()
            ->count(3)
            ->sequence(
                ['name' => "{$this->tableScope} pending", 'status' => Pending::$name],
                ['name' => "{$this->tableScope} active", 'status' => Active::$name],
                ['name' => "{$this->tableScope} inactive", 'status' => Inactive::$name],
            )
            ->create();
    });

    test('can view the list users page', function () {
        get(route('admin.users.index'))->assertSuccessful();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->searchTable($this->tableScope)
            ->assertCountTableRecords(3)
            ->assertCanSeeTableRecords($this->users);
    });

    test('can filter users by status', function () {
        livewire(UsersList::class)
            ->removeTableFilters()
            ->searchTable($this->tableScope)
            ->filterTable('status', Pending::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->users->where('status', Pending::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Pending::$name))
            ->resetTableFilters()
            ->searchTable($this->tableScope)
            ->filterTable('status', Active::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->users->where('status', Active::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Active::$name))
            ->resetTableFilters()
            ->searchTable($this->tableScope)
            ->filterTable('status', Inactive::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->users->where('status', Inactive::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Inactive::$name));
    });

    test('can filter by the presence of assigned characters', function () {
        Character::factory()->hasAttached($this->users->first())->create();

        livewire(UsersList::class)
            ->removeTableFilters()
            ->searchTable($this->tableScope)
            ->filterTable('hasAssignedCharacters', true)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$this->users->first()])
            ->removeTableFilters()
            ->searchTable($this->tableScope)
            ->filterTable('hasAssignedCharacters', false)
            ->assertCountTableRecords(2)
            ->assertCanNotSeeTableRecords([$this->users->first()]);
    });

    describe('can filter by the timeframe of last sign in', function () {
        beforeEach(function () {
            $this->tableScope = 'manage-users-login-'.str()->random(8);
            $tableScope = $this->tableScope;

            signIn(permissions: 'user.create');

            $this->users = User::factory()
                ->count(3)
                ->active()
                ->state(fn () => ['name' => "{$tableScope} ".str()->random(8)])
                ->create();
        });

        test('1 week', function () {
            $user = $this->users->first();

            $login = new Login;
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastLogin', '7 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('2 weeks', function () {
            $user = $this->users->first();

            $login = new Login;
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(10),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastLogin', '14 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('1 month', function () {
            $user = $this->users->first();

            $login = new Login;
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(20),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastLogin', '30 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });
    });

    describe('can filter by the timeframe of last published post', function () {
        beforeEach(function () {
            $this->tableScope = 'manage-users-posts-'.str()->random(8);
            $tableScope = $this->tableScope;

            signIn(permissions: 'user.create');

            $this->users = User::factory()
                ->count(3)
                ->active()
                ->state(fn () => ['name' => "{$tableScope} ".str()->random(8)])
                ->create();
        });

        test('1 week', function () {
            $user = $this->users->first();

            $post = Post::factory()->published()->create();
            $post->characterAuthors()->detach();
            $post->userAuthors()->detach();
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastPost', '7 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('2 weeks', function () {
            $user = $this->users->first();

            $post = Post::factory()->published()->create([
                'published_at' => now()->subDays(10),
            ]);
            $post->characterAuthors()->detach();
            $post->userAuthors()->detach();
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastPost', '14 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('1 month', function () {
            $user = $this->users->first();

            $post = Post::factory()->published()->create([
                'published_at' => now()->subDays(20),
            ]);
            $post->characterAuthors()->detach();
            $post->userAuthors()->detach();
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->removeTableFilters()
                ->searchTable($this->tableScope)
                ->filterTable('lastPost', '30 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });
    });

    test('can search users by name, email, or character name', function () {
        $token = str()->random(8);
        $characterToken = str()->random(8);

        $user = User::factory()->create([
            'name' => "ManageUsers {$token}",
            'email' => "manage-users-{$token}@example.com",
        ]);
        $characterUser = User::factory()->create();

        Character::factory()
            ->hasAttached($characterUser)
            ->create(['name' => "Character {$characterToken}"]);

        livewire(UsersList::class)
            ->removeTableFilters()
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->removeTableFilters()
            ->searchTable($token)
            ->assertCanSeeTableRecords([$user])
            ->removeTableFilters()
            ->searchTable("manage-users-{$token}")
            ->assertCanSeeTableRecords([$user])
            ->removeTableFilters()
            ->searchTable($characterToken)
            ->assertCanSeeTableRecords([$characterUser]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage users page', function () {
        get(route('admin.users.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage users page', function () {
        get(route('admin.users.index'))->assertRedirectToRoute('login');
    });
});
