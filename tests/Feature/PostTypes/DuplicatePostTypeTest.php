<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Stories\Events\PostTypeDuplicated;
use Nova\Stories\Livewire\PostTypesList;
use Nova\Stories\Models\PostType;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('stories');
uses()->group('post-types');

beforeEach(function () {
    $this->postType = PostType::factory()->create();

    signIn(permissions: ['post-type.create', 'post-type.update']);
});

test('an authorized user can duplicate a post type', function () {
    Event::fake();

    $data = [
        'name' => 'New post type',
    ];

    livewire(PostTypesList::class)
        ->callTableAction(ReplicateAction::class, $this->postType, data: $data)
        ->assertNotified();

    assertDatabaseHas(PostType::class, $data);

    Event::assertDispatched(PostTypeDuplicated::class);
});
