<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Models\Character;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Roles\Models\Role;
use Nova\Stories\Livewire\PostSetup;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Nova\Stories\Models\Story;

use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = new Post;

    $this->user = createUser(permissions: 'post.create');
});

test('component mounts', function () {
    signInAs($this->user);

    livewire(PostSetup::class, ['post' => $this->post])
        ->assertSet('post', $this->post);
});

describe('story selection', function () {
    beforeEach(fn () => signInAs($this->user));

    test('only shows current stories', function () {
        $completedStory = Story::factory()->completed()->create();
        $currentStory = Story::factory()->current()->create();
        $upcomingStory = Story::factory()->upcoming()->create();

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertViewHas(
                'currentStories',
                fn (Collection $stories): bool => $stories->contains($currentStory)
            )
            ->assertViewHas(
                'currentStories',
                fn (Collection $stories): bool => $stories->doesntContain($completedStory)
            )
            ->assertViewHas(
                'currentStories',
                fn (Collection $stories): bool => $stories->doesntContain($upcomingStory)
            );
    });

    test('validates story must be current', function () {
        $story = Story::factory()->upcoming()->create();
        $postType = PostType::factory()->create();
        $character = Character::factory()->active()->primary()->create();
        $this->user->activeCharacters()->attach($character);

        livewire(PostSetup::class, ['post' => $this->post])
            ->set('storyId', $story->id)
            ->set('postTypeId', $postType->id)
            ->set('characterId', $character->id)
            ->call('saveAndContinueWriting')
            ->assertHasErrors(['storyId']);
    });
});

describe('post type selection', function () {
    beforeEach(fn () => signInAs($this->user));

    test('only shows active post types', function () {
        $activePostType = PostType::factory()->active()->create();
        $inactivePostType = PostType::factory()->inactive()->create();

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->contains($activePostType)
            )
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->doesntContain($inactivePostType)
            );
    });

    test('only shows post types the user is allowed to use', function () {
        $role = Role::factory()->create();

        $unprotectedPostType = PostType::factory()->active()->create();
        $protectedPostType = PostType::factory()->active()->create([
            'role_id' => $role->id,
        ]);

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->contains($unprotectedPostType)
            )
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->doesntContain($protectedPostType)
            );
    });

    test('shows post types the user is allowed to use', function () {
        $role = Role::factory()->create();

        $this->user->roles()->attach($role->id);

        $unprotectedPostType = PostType::factory()->active()->create();
        $protectedPostType = PostType::factory()->active()->create([
            'role_id' => $role->id,
        ]);

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->contains($unprotectedPostType)
            )
            ->assertViewHas(
                'availablePostTypes',
                fn (Collection $postTypes): bool => $postTypes->contains($protectedPostType)
            );
    });

    test('forbids saving when selected post type is not writable by the user', function () {
        $restrictedRole = Role::factory()->create();
        $restrictedPostType = PostType::factory()->create([
            'role_id' => $restrictedRole->id,
        ]);

        livewire(PostSetup::class, ['post' => $this->post])
            ->set('postTypeId', $restrictedPostType->id)
            ->call('saveAndContinueWriting')
            ->assertForbidden();
    });
});

describe('character selection', function () {
    beforeEach(fn () => signInAs($this->user));

    test('only shows active characters assigned to the current user', function () {
        $primaryCharacter = Character::factory()->active()->primary()->create();
        $secondaryCharacter = Character::factory()->active()->secondary()->create();
        $inactiveCharacter = Character::factory()->inactive()->secondary()->create();
        $unlinkedCharacter = Character::factory()->active()->support()->create();

        $this->user->characters()->attach($primaryCharacter);
        $this->user->characters()->attach($secondaryCharacter);
        $this->user->characters()->attach($inactiveCharacter);

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertViewHas(
                'characters',
                fn (Collection $characters): bool => $characters->contains($primaryCharacter)
            )
            ->assertViewHas(
                'characters',
                fn (Collection $characters): bool => $characters->contains($secondaryCharacter)
            )
            ->assertViewHas(
                'characters',
                fn (Collection $characters): bool => $characters->doesntContain($inactiveCharacter)
            )
            ->assertViewHas(
                'characters',
                fn (Collection $characters): bool => $characters->doesntContain($unlinkedCharacter)
            );
    });

    test('validates character belongs to user', function () {
        $story = Story::factory()->current()->create();
        $postType = PostType::factory()->create();
        $character = Character::factory()->active()->primary()->create();

        livewire(PostSetup::class, ['post' => $this->post])
            ->set('storyId', $story->id)
            ->set('postTypeId', $postType->id)
            ->set('characterId', $character->id)
            ->call('saveAndContinueWriting')
            ->assertHasErrors(['characterId']);
    });
});

describe('auto-selects', function () {
    beforeEach(fn () => signInAs($this->user));

    test('story if there is only one current story', function () {
        $story = Story::factory()->current()->create();

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertSet('storyId', $story->id);
    });

    test('post type if there is only one active post type the user can write in', function () {
        $postType = PostType::factory()->active()->create();

        PostType::where('id', '!=', $postType->id)->forceDelete();

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertSet('postTypeId', $postType->id);
    });

    test('character if there is only one active characters linked to the user', function () {
        $character = Character::factory()->active()->primary()->create();

        $this->user->characters()->attach($character);

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertSet('characterId', $character->id);
    });

    test('story, post type, and character when only one option exists', function () {
        Story::query()->update(['status' => Upcoming::$name]);
        PostType::query()->update(['status' => BasicStatus::Inactive]);

        $currentStory = Story::factory()->current()->create();
        $availablePostType = PostType::factory()->create();
        $character = Character::factory()->active()->primary()->create();

        $this->user->activeCharacters()->sync([$character->id]);

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertSet('storyId', $currentStory->id)
            ->assertSet('postTypeId', $availablePostType->id)
            ->assertSet('characterId', $character->id)
            ->assertSet('canContinueWriting', true);
    });

    test('does not when multiple options exist', function () {
        Story::query()->update(['status' => Upcoming::$name]);
        PostType::query()->update(['status' => BasicStatus::Inactive]);

        Story::factory()->count(2)->current()->create();
        PostType::factory()->count(2)->create();
        $characters = Character::factory()->count(2)->active()->primary()->create();

        $this->user->activeCharacters()->sync($characters->pluck('id')->all());

        livewire(PostSetup::class, ['post' => $this->post])
            ->assertSet('storyId', null)
            ->assertSet('postTypeId', null)
            ->assertSet('characterId', null)
            ->assertSet('canContinueWriting', false);
    });
});

test('can continue writing is only true when all setup selections are made', function () {
    signInAs($this->user);

    $story = Story::factory()->current()->create();
    $postType = PostType::factory()->create();
    $character = Character::factory()->active()->primary()->create();
    $this->user->activeCharacters()->attach($character);

    livewire(PostSetup::class, ['post' => $this->post])
        ->set('storyId', null)
        ->set('postTypeId', null)
        ->set('characterId', null)
        ->assertSet('canContinueWriting', false)
        ->set('storyId', $story->id)
        ->assertSet('canContinueWriting', false)
        ->set('postTypeId', $postType->id)
        ->assertSet('canContinueWriting', false)
        ->set('characterId', $character->id)
        ->assertSet('canContinueWriting', true);
});

test('validates required fields', function () {
    signInAs($this->user);

    livewire(PostSetup::class, ['post' => $this->post])
        ->call('saveAndContinueWriting')
        ->assertHasErrors(['storyId', 'postTypeId', 'characterId']);
});

test('saves valid post setup data', function () {
    signInAs($this->user);

    $initialMaxPostId = (int) (Post::query()->max('id') ?? 0);

    $story = Story::factory()->current()->create();
    $postType = PostType::factory()->create();
    $character = Character::factory()->active()->primary()->create();

    $this->user->activeCharacters()->attach($character);

    $component = livewire(PostSetup::class, ['post' => $this->post])
        ->set('storyId', $story->id)
        ->set('postTypeId', $postType->id)
        ->set('characterId', $character->id);

    $component->call('saveAndContinueWriting');

    $createdPost = Post::query()->where('id', '>', $initialMaxPostId)->latest('id')->firstOrFail();

    $component->assertRedirect(route('admin.posts.edit', $createdPost));

    $createdPost->load('characterAuthors', 'userAuthors');

    expect($createdPost->story_id)->toBe($story->id);
    expect($createdPost->post_type_id)->toBe($postType->id);
    expect($createdPost->status->equals(Draft::class))->toBeTrue();
    expect($createdPost->characterAuthors)->toHaveCount(1);
    expect($createdPost->characterAuthors->first()->is($character))->toBeTrue();
    expect((int) $createdPost->characterAuthors->first()->pivot->user_id)->toBe($this->user->id);
    expect($createdPost->userAuthors)->toHaveCount(0);
});
