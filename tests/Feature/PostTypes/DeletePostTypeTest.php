<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Stories\Events\PostTypeDeleted;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('post-types', 'storytelling');

beforeEach(function () {
    $this->postTypes = PostType::factory()->count(10)->create();

    signIn(permissions: 'post-type.delete');
});

test('a post type without posts is force deleted', function () {
    Event::fake();

    $postTypeToDelete = $this->postTypes->first();

    livewire(PostTypesList::class)
        ->assertCanSeeTableRecords([$postTypeToDelete])
        ->callAction(TestAction::make(DeleteAction::class)->table($postTypeToDelete))
        ->assertCanNotSeeTableRecords([$postTypeToDelete])
        ->assertNotified();

    assertDatabaseMissing(PostType::class, [
        'id' => $postTypeToDelete->id,
    ]);

    Event::assertDispatched(PostTypeDeleted::class);
});

test('a post type with posts is soft deleted', function () {
    $postTypeToDelete = $this->postTypes->first();

    Character::factory()->count(5)->create();

    Post::factory()->create([
        'post_type_id' => $postTypeToDelete->id,
    ]);

    livewire(PostTypesList::class)
        ->assertCanSeeTableRecords([$postTypeToDelete])
        ->callAction(TestAction::make(DeleteAction::class)->table($postTypeToDelete))
        ->assertCanNotSeeTableRecords([$postTypeToDelete])
        ->assertNotified();

    assertSoftDeleted(PostType::class, [
        'id' => $postTypeToDelete->id,
    ]);
});

test('can bulk delete post types', function () {
    $postTypes = $this->postTypes->take(3);

    livewire(PostTypesList::class)
        ->assertCanSeeTableRecords($postTypes)
        ->selectTableRecords($postTypes)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertCanNotSeeTableRecords($postTypes)
        ->assertNotified();

    foreach ($postTypes as $postType) {
        assertDatabaseMissing(PostType::class, [
            'id' => $postType->id,
        ]);
    }
});
