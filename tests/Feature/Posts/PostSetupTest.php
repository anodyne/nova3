<?php

declare(strict_types=1);

use Livewire\Livewire;
use Nova\Characters\Models\Character;
use Nova\Stories\Livewire\PostSetup;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

uses()->group('posts', 'storytelling');

beforeEach(function () {
    $this->post = new Post;
    $this->user = User::factory()->create();
});

test('post setup component mounts correctly', function () {
    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->assertSet('post', $this->post);
});

test('validates required fields', function () {
    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->call('save')
        ->assertHasErrors(['storyId', 'postTypeId', 'characterId']);
});

test('validates story must be current', function () {
    $story = Story::factory()->upcoming()->create();

    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->set('storyId', $story->id)
        ->call('save')
        ->assertHasErrors(['storyId']);
});

test('validates post type authorization', function () {
    $postType = PostType::factory()->hasRole()->create();

    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->set('postTypeId', $postType->id)
        ->call('save')
        ->assertHasErrors(['postTypeId']);
});

test('validates character belongs to user', function () {
    $character = Character::factory()->active()->support()->create();

    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->set('characterId', $character->id)
        ->call('save')
        ->assertHasErrors(['characterId']);
});

test('saves valid post setup data', function () {
    $story = Story::factory()->current()->create();
    $postType = PostType::factory()->create();
    $character = Character::factory()->active()->primary()->create();

    $this->user->activeCharacters()->attach($character);

    Livewire::actingAs($this->user)
        ->test(PostSetup::class, ['post' => $this->post])
        ->set('storyId', $story->id)
        ->set('postTypeId', $postType->id)
        ->set('characterId', $character->id)
        ->call('save')
        ->assertRedirect(route('admin.posts.edit', $this->post));

    $this->post->refresh();

    expect($this->post->story_id)->toBe($story->id);
    expect($this->post->post_type_id)->toBe($postType->id);
});
