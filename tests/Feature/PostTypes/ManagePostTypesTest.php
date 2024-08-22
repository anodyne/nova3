<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Roles\Models\Role;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('post-types');

beforeEach(function () {
    $this->postTypes = PostType::factory()
        ->count(10)
        ->sequence(
            ['status' => PostTypeStatus::active],
            ['status' => PostTypeStatus::inactive],
        )
        ->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.create');
    });

    test('can view the list post types page', function () {
        get(route('admin.post-types.index'))->assertSuccessful();

        livewire(PostTypesList::class)
            ->assertCountTableRecords(PostType::count());
    });

    test('can filter post types by status', function () {
        livewire(PostTypesList::class)
            ->filterTable('status', PostTypeStatus::active->value)
            ->assertCanSeeTableRecords($this->postTypes->where('status', PostTypeStatus::active))
            ->assertCanNotSeeTableRecords($this->postTypes->where('status', PostTypeStatus::inactive))
            ->filterTable('status', PostTypeStatus::inactive->value)
            ->assertCanSeeTableRecords($this->postTypes->where('status', PostTypeStatus::inactive))
            ->assertCanNotSeeTableRecords($this->postTypes->where('status', PostTypeStatus::active));
    });

    test('can filter post types by those that require a role', function () {
        livewire(PostTypesList::class)
            ->filterTable('requires_role', true)
            ->assertCountTableRecords(2);
    });

    test('can filter post types by role', function () {
        $roleId = Role::where('name', 'story-manager')->first()->id;

        livewire(PostTypesList::class)
            ->filterTable('roles', $roleId)
            ->assertCountTableRecords(2);
    });

    test('can filter post types by those that have posts', function () {
        $postType = PostType::factory()->create();

        Post::factory()->published()->create(['post_type_id' => $postType->id]);

        livewire(PostTypesList::class)
            ->filterTable('has_posts', true)
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$postType]);
    });

    test('can search post types by name', function () {
        PostType::factory()->create(['name' => 'My post type']);

        livewire(PostTypesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->resetTableFilters()
            ->searchTable('My post type')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with post type create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.create');
    });

    test('has the correct permissions', function () {
        livewire(PostTypesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->postTypes->first())
            ->assertTableActionHidden(EditAction::class, $this->postTypes->first())
            ->assertTableActionHidden(DeleteAction::class, $this->postTypes->first());
    });
});

describe('authorized user with post type delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.delete');
    });

    test('has the correct permissions', function () {
        livewire(PostTypesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->postTypes->first())
            ->assertTableActionHidden(EditAction::class, $this->postTypes->first())
            ->assertTableActionVisible(DeleteAction::class, $this->postTypes->first());
    });
});

describe('authorized user with post type update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.update');
    });

    test('has the correct permissions', function () {
        livewire(PostTypesList::class)
            ->assertTableActionHidden(ViewAction::class, $this->postTypes->first())
            ->assertTableActionVisible(EditAction::class, $this->postTypes->first())
            ->assertTableActionHidden(DeleteAction::class, $this->postTypes->first());
    });
});

describe('authorized user with post type view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'post-type.view');
    });

    test('has the correct permissions', function () {
        livewire(PostTypesList::class)
            ->assertTableActionVisible(ViewAction::class, $this->postTypes->first())
            ->assertTableActionHidden(EditAction::class, $this->postTypes->first())
            ->assertTableActionHidden(DeleteAction::class, $this->postTypes->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage post types page', function () {
        get(route('admin.post-types.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage post types page', function () {
        get(route('admin.post-types.index'))
            ->assertRedirectToRoute('login');
    });
});
