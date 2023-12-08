<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\RestoreBulkAction;
use Nova\Stories\Events\PostTypeRestored;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('post-types');

beforeEach(function () {
    $postTypes = PostType::factory()->count(5)->create();
    $postTypes->each->delete();

    signIn(permissions: 'post-type.restore');
});

test('an authorized user can restore a soft deleted post type', function () {
    Event::fake();

    $postTypeToRestore = PostType::onlyTrashed()->first();

    livewire(PostTypesList::class)
        ->filterTable('trashed', false)
        ->assertTableActionVisible(RestoreAction::class, $postTypeToRestore)
        ->callTableAction(RestoreAction::class, $postTypeToRestore)
        ->assertNotified();

    assertNotSoftDeleted(PostType::class, [
        'id' => $postTypeToRestore->id,
    ]);

    Event::assertDispatched(PostTypeRestored::class);
});

test('the restore action is not available for non-deleted records', function () {
    $postType = PostType::factory()->create();

    livewire(PostTypesList::class)
        ->assertTableActionHidden(RestoreAction::class, $postType);
});

test('an authorized user can bulk restore soft deleted post types', function () {
    $postTypesToRestore = PostType::onlyTrashed()->limit(3)->get();

    livewire(PostTypesList::class)
        ->filterTable('trashed', false)
        ->callTableBulkAction(RestoreBulkAction::class, $postTypesToRestore)
        ->assertNotified();

    foreach ($postTypesToRestore as $postType) {
        assertDatabaseHas(PostType::class, [
            'id' => $postType->id,
        ]);
    }
});
