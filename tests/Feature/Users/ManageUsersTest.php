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
        signIn(permissions: 'user.create');

        $this->users = User::factory()
            ->count(3)
            ->sequence(
                ['status' => Pending::$name],
                ['status' => Active::$name],
                ['status' => Inactive::$name],
            )
            ->create();
    });

    test('can view the list users page', function () {
        get(route('users.index'))->assertSuccessful();

        livewire(UsersList::class)
            ->assertCountTableRecords(4)
            ->assertCanSeeTableRecords($this->users);
    });

    test('can filter users by status', function () {
        livewire(UsersList::class)
            ->filterTable('status', Pending::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->users->where('status', Pending::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Pending::$name))
            ->resetTableFilters()
            ->filterTable('status', Active::$name)
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords($this->users->where('status', Active::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Active::$name))
            ->resetTableFilters()
            ->filterTable('status', Inactive::$name)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords($this->users->where('status', Inactive::$name))
            ->assertCanNotSeeTableRecords($this->users->where('status', '!=', Inactive::$name));
    });

    test('can filter by the presence of assigned characters', function () {
        Character::factory()->hasAttached($this->users->first())->create();

        livewire(UsersList::class)
            ->filterTable('assigned_characters', true)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$this->users->first()])
            ->resetTableFilters()
            ->filterTable('assigned_characters', false)
            ->assertCountTableRecords(3)
            ->assertCanNotSeeTableRecords([$this->users->first()]);
    });

    describe('can filter by the timeframe of last sign in', function () {
        beforeEach(function () {
            signIn(permissions: 'user.create');

            $this->users = User::factory()
                ->count(3)
                ->active()
                ->create();
        });

        test('1 week', function () {
            $user = $this->users->first();

            $login = new Login();
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->filterTable('last_login', '7 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('2 weeks', function () {
            $user = $this->users->first();

            $login = new Login();
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(10),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->filterTable('last_login', '14 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('1 month', function () {
            $user = $this->users->first();

            $login = new Login();
            $login->forceFill([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(20),
            ]);
            $login->save();

            livewire(UsersList::class)
                ->filterTable('last_login', '30 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });
    });

    describe('can filter by the timeframe of last published post', function () {
        beforeEach(function () {
            signIn(permissions: 'user.create');

            $this->users = User::factory()
                ->count(3)
                ->active()
                ->create();
        });

        test('1 week', function () {
            $user = $this->users->first();

            $post = Post::factory()->create([
                'status' => 'published',
                'published_at' => now(),
            ]);
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->filterTable('last_post', '7 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('2 weeks', function () {
            $user = $this->users->first();

            $post = Post::factory()->create([
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ]);
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->filterTable('last_post', '14 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });

        test('1 month', function () {
            $user = $this->users->first();

            $post = Post::factory()->create([
                'status' => 'published',
                'published_at' => now()->subDays(20),
            ]);
            $post->userAuthors()->attach($user->id, ['user_id' => $user->id]);

            livewire(UsersList::class)
                ->filterTable('last_post', '30 days')
                ->assertCountTableRecords(1)
                ->assertCanSeeTableRecords([$user])
                ->assertCanNotSeeTableRecords([$this->users[1]]);
        });
    });

    test('can search users by name or email', function () {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        livewire(UsersList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable('doe')
            ->assertCountTableRecords(1)
            ->resetTableFilters()
            ->searchTable('johndoe')
            ->assertCountTableRecords(1);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage users page', function () {
        get(route('users.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage users page', function () {
        get(route('users.index'))->assertRedirectToRoute('login');
    });
});
