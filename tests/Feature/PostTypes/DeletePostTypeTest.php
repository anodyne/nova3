<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Stories\Events\PostTypeDeleted;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('post-types');

beforeEach(function () {
    $this->postTypes = PostType::factory()->count(10)->create();

    signIn(permissions: 'post-type.delete');
});

test('an authorized user can force delete a post type without posts', function () {
    Event::fake();

    $postTypeToDelete = $this->postTypes->first();

    livewire(PostTypesList::class)
        ->callTableAction(DeleteAction::class, $postTypeToDelete)
        ->assertCanNotSeeTableRecords([$postTypeToDelete])
        ->assertNotified();

    assertDatabaseMissing(PostType::class, [
        'id' => $postTypeToDelete->id,
    ]);

    Event::assertDispatched(PostTypeDeleted::class);
});

test('an authorized user can soft delete a post type that has posts', function () {
    $postTypeToDelete = $this->postTypes->first();

    Post::factory()->create([
        'post_type_id' => $postTypeToDelete->id,
    ]);

    livewire(PostTypesList::class)
        ->callTableAction(DeleteAction::class, $postTypeToDelete)
        ->assertCanNotSeeTableRecords([$postTypeToDelete])
        ->assertNotified();

    assertSoftDeleted(PostType::class, [
        'id' => $postTypeToDelete->id,
    ]);
});

test('an authorized user can bulk delete post types', function () {
    $postTypes = $this->postTypes->take(3);

    livewire(PostTypesList::class)
        ->callTableBulkAction(DeleteBulkAction::class, $postTypes)
        ->assertNotified();

    foreach ($postTypes as $postType) {
        assertDatabaseMissing(PostType::class, [
            'id' => $postType->id,
        ]);
    }
});
