<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Nova\Characters\Models\Character;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Livewire\PostAuthors;
use Nova\Stories\Livewire\PostAuthorsEditor;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->user = createUser(permissions: 'post.create');
    $this->otherUser = createUser();

    $this->singleUserCharacter = Character::factory()->active()->primary()->create();
    $this->singleUserCharacter->users()->attach($this->user->id, ['primary' => true]);

    $this->multiUserCharacter = Character::factory()->active()->support()->create();
    $this->multiUserCharacter->users()->attach($this->user->id, ['primary' => true]);
    $this->multiUserCharacter->users()->attach($this->otherUser->id, ['primary' => false]);

    $this->postType = PostType::factory()->create([
        'options' => Options::from(
            notifiesUsers: true,
            includedInPostTracking: true,
            allowsMultipleAuthors: true,
            allowsCharacterAuthors: true,
            allowsUserAuthors: true,
            showContentInTimelineView: false,
            editTimeframe: PostEditTimeframe::Hour4,
        ),
    ]);

    $this->post = Post::factory()->draft()->create([
        'post_type_id' => $this->postType->id,
        'title' => 'Post title',
        'location' => 'Post location',
        'day' => 'Day 1',
        'time' => '0900 hours',
    ]);

    $this->post->characterAuthors()->detach();
    $this->post->userAuthors()->detach();
    $this->post->userAuthors()->attach($this->user, ['user_id' => $this->user->id, 'as' => null]);
    $this->post->refresh();
});

describe('PostAuthors', function () {
    test('mounts', function () {
        livewire(PostAuthors::class, ['post' => $this->post])
            ->assertSet('postId', $this->post->id)
            ->assertSet('postTypeId', $this->post->post_type_id)
            ->assertCount('characterAuthorsArr', 0)
            ->assertCount('userAuthorsArr', 1);
    });

    test('shows existing authors', function () {
        livewire(PostAuthors::class, ['post' => $this->post])
            ->assertViewHas('hasAuthors', true)
            ->assertSeeText('Additional character')
            ->assertSeeText($this->user->name);
    });

    test('shows empty state when there are no authors', function () {
        $this->post->userAuthors()->detach();
        $this->post->characterAuthors()->detach();
        $this->post->refresh();

        livewire(PostAuthors::class, ['post' => $this->post])
            ->assertViewHas('hasAuthors', false)
            ->assertSeeText('No authors');
    });

    test('can open editor slide over', function () {
        livewire(PostAuthors::class, ['post' => $this->post])
            ->call('openForEditing')
            ->assertDispatched('modal-open');
    });

    test('can handle author updates from PostAuthorsEditor', function () {
        $updatedState = livewire(PostAuthors::class, ['post' => $this->post])
            ->call('addCharacterAuthor', $this->singleUserCharacter->id)
            ->set("userAuthorsPivotData.{$this->user->id}.as", 'Captain');

        livewire(PostAuthors::class, ['post' => $this->post])
            ->dispatch(
                'update-post-authors',
                characterAuthors: $updatedState->get('characterAuthorsArr'),
                characterAuthorsPivotData: $updatedState->get('characterAuthorsPivotData'),
                userAuthors: $updatedState->get('userAuthorsArr'),
                userAuthorsPivotData: $updatedState->get('userAuthorsPivotData')
            )
            ->assertCount('characterAuthorsArr', 1)
            ->assertSet("userAuthorsPivotData.{$this->user->id}.as", 'Captain')
            ->assertDispatched('post-updated');
    });

    test('maps character and user authors to expected array shapes on mount', function () {
        $this->post->characterAuthors()->attach($this->singleUserCharacter, ['user_id' => $this->user->id]);
        $this->post->userAuthors()->syncWithoutDetaching([
            $this->otherUser->id => ['user_id' => $this->otherUser->id, 'as' => 'Science officer'],
        ]);
        $this->post->refresh();

        $component = livewire(PostAuthors::class, ['post' => $this->post]);

        $characterAuthor = collect($component->get('characterAuthorsArr'))->first();
        $userAuthors = collect($component->get('userAuthorsArr'))->keyBy('id');

        expect($characterAuthor)->toBeArray();
        expect($characterAuthor)->toHaveKeys(['id', 'name', 'type', 'avatar_url', 'activeUsers', 'pivot']);
        expect($characterAuthor['pivot'])->toHaveKeys(['user', 'user_id']);
        expect($characterAuthor['pivot']['user_id'])->toBe($this->user->id);

        expect($userAuthors->get($this->user->id))->toBeArray();
        expect($userAuthors->get($this->user->id))->toHaveKeys(['id', 'name', 'avatar_url', 'pivot']);
        expect($userAuthors->get($this->user->id)['pivot'])->toHaveKeys(['user', 'user_id', 'as']);
        expect($userAuthors->get($this->user->id)['pivot']['user_id'])->toBe($this->user->id);
        expect($userAuthors->get($this->user->id)['pivot']['as'])->toBeNull();

        expect($userAuthors->get($this->otherUser->id)['pivot']['user_id'])->toBe($this->otherUser->id);
        expect($userAuthors->get($this->otherUser->id)['pivot']['as'])->toBe('Science officer');
    });

    test('can save post authors', function () {
        signInAs($this->user);

        livewire(PostAuthors::class, ['post' => $this->post])
            ->call('addCharacterAuthor', $this->singleUserCharacter->id)
            ->call('addUserAuthor', $this->otherUser->id)
            ->set("userAuthorsPivotData.{$this->otherUser->id}.as", 'Guest character')
            ->dispatch('save-post')
            ->assertDispatchedTo(PostComposer::class, 'save-post-completed');

        $this->post->refresh()->load('characterAuthors', 'userAuthors');

        expect($this->post->characterAuthors->pluck('id'))->toContain($this->singleUserCharacter->id);
        expect($this->post->userAuthors->pluck('id'))->toContain($this->user->id);
        expect($this->post->userAuthors->pluck('id'))->toContain($this->otherUser->id);
        expect($this->post->userAuthors->firstWhere('id', $this->otherUser->id)?->pivot?->as)->toBe('Guest character');
    });
});

describe('PostAuthorsEditor', function () {
    test('mounts', function () {
        $authors = livewire(PostAuthors::class, ['post' => $this->post]);

        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => $authors->get('characterAuthorsArr'),
            'userAuthors' => $authors->get('userAuthorsArr'),
        ])
            ->assertSet('postId', $this->post->id)
            ->assertSet('postTypeId', $this->postType->id)
            ->assertCount('characterAuthorsArr', 0)
            ->assertCount('userAuthorsArr', 1);
    });

    test('shows mixed author placeholder when post type allows both characters and users', function () {
        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->assertSet('authorSearchPlaceholder', 'Find a character or user to add as an author');
    });

    test('shows character-only placeholder when post type only allows character authors', function () {
        $characterOnlyPostType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: true,
                allowsUserAuthors: false,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $characterOnlyPostType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->assertSet('authorSearchPlaceholder', 'Find a character to add as an author');
    });

    test('shows user-only placeholder when post type only allows user authors', function () {
        $userOnlyPostType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: true,
                allowsCharacterAuthors: false,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $userOnlyPostType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->assertSet('authorSearchPlaceholder', 'Find a user to add as an author');
    });

    test('can add a character author with a single active user and auto-assign the user', function () {
        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])
            ->call('addCharacterAuthor', $this->singleUserCharacter->id)
            ->assertSet("characterAuthorsPivotData.{$this->singleUserCharacter->id}.user_id", $this->user->id)
            ->assertViewHas('canSave', true)
            ->assertDispatched('dropdown-close');
    });

    test('requires assigning a user for a character with multiple active users before saving', function () {
        $component = livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])
            ->call('addCharacterAuthor', $this->multiUserCharacter->id)
            ->assertSet("characterAuthorsPivotData.{$this->multiUserCharacter->id}.user_id", null)
            ->assertViewHas('canSave', false);

        $component->call('save')
            ->assertNotDispatched('update-post-authors');

        $component->set("characterAuthorsPivotData.{$this->multiUserCharacter->id}.user_id", $this->otherUser->id)
            ->assertViewHas('canSave', true)
            ->call('save')
            ->assertDispatched('update-post-authors');
    });

    test('can add a user author and set who they are playing', function () {
        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])
            ->call('addUserAuthor', $this->otherUser->id)
            ->set("userAuthorsPivotData.{$this->otherUser->id}.as", 'Chief engineer')
            ->assertSet("userAuthorsPivotData.{$this->otherUser->id}.as", 'Chief engineer')
            ->call('save')
            ->assertDispatched('update-post-authors');
    });

    test('dispatches update payload using expected array shapes', function () {
        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])
            ->call('addCharacterAuthor', $this->singleUserCharacter->id)
            ->call('addUserAuthor', $this->otherUser->id)
            ->set("userAuthorsPivotData.{$this->otherUser->id}.as", 'Temp role')
            ->call('save')
            ->assertDispatched('update-post-authors', function (string $event, array $params): bool {
                [$characterAuthors, $characterAuthorsPivotData, $userAuthors, $userAuthorsPivotData] = $params;

                $characterAuthor = collect($characterAuthors)->first();
                $userAuthor = collect($userAuthors)->firstWhere('id', $this->otherUser->id);

                return $event === 'update-post-authors'
                    && is_array($characterAuthors)
                    && is_array($characterAuthorsPivotData)
                    && is_array($userAuthors)
                    && is_array($userAuthorsPivotData)
                    && isset($characterAuthor['id'], $characterAuthor['pivot']['user_id'])
                    && isset($characterAuthorsPivotData[$this->singleUserCharacter->id]['user_id'])
                    && isset($userAuthor['id'], $userAuthor['pivot']['as'])
                    && isset($userAuthorsPivotData[$this->otherUser->id]['user_id'], $userAuthorsPivotData[$this->otherUser->id]['as'])
                    && $userAuthorsPivotData[$this->otherUser->id]['as'] === 'Temp role';
            });
    });

    test('syncs character author pivot updates into array state', function () {
        $component = livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->call('addCharacterAuthor', $this->multiUserCharacter->id);

        expect($component->get('characterAuthorsValidationErrors'))->toHaveKey($this->multiUserCharacter->id);

        $component->set("characterAuthorsPivotData.{$this->multiUserCharacter->id}.user_id", $this->otherUser->id);

        $updatedCharacter = collect($component->get('characterAuthorsArr'))->firstWhere('id', $this->multiUserCharacter->id);

        expect($updatedCharacter['pivot']['user_id'])->toBe($this->otherUser->id);
        expect($component->get('characterAuthorsValidationErrors'))->not->toHaveKey($this->multiUserCharacter->id);
    });

    test('syncs user author alias updates into array state', function () {
        $component = livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->call('addUserAuthor', $this->otherUser->id)
            ->set("userAuthorsPivotData.{$this->otherUser->id}.as", 'First officer');

        $updatedUser = collect($component->get('userAuthorsArr'))->firstWhere('id', $this->otherUser->id);

        expect($updatedUser['pivot']['as'])->toBe('First officer');
    });

    test('removes character author and associated pivot data', function () {
        $component = livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->call('addCharacterAuthor', $this->multiUserCharacter->id);

        expect($component->get('characterAuthorsPivotData'))->toHaveKey($this->multiUserCharacter->id);
        expect($component->get('characterAuthorsValidationErrors'))->toHaveKey($this->multiUserCharacter->id);

        $component->call('removeCharacterAuthor', $this->multiUserCharacter->id);

        expect($component->get('characterAuthorsPivotData'))->not->toHaveKey($this->multiUserCharacter->id);
        expect($component->get('characterAuthorsValidationErrors'))->not->toHaveKey($this->multiUserCharacter->id);
    });

    test('removes user author and associated pivot data', function () {
        $component = livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => [],
            'userAuthors' => [],
        ])->call('addUserAuthor', $this->otherUser->id);

        expect($component->get('userAuthorsPivotData'))->toHaveKey($this->otherUser->id);

        $component->call('removeUserAuthor', $this->otherUser->id);

        expect($component->get('userAuthorsPivotData'))->not->toHaveKey($this->otherUser->id);
    });

    test('cannot add more authors when post type does not allow multiple authors and an author already exists', function () {
        $singleAuthorPostType = PostType::factory()->create([
            'options' => Options::from(
                notifiesUsers: true,
                includedInPostTracking: true,
                allowsMultipleAuthors: false,
                allowsCharacterAuthors: true,
                allowsUserAuthors: true,
                showContentInTimelineView: false,
                editTimeframe: PostEditTimeframe::Hour4,
            ),
        ]);

        $authors = livewire(PostAuthors::class, ['post' => $this->post]);

        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $singleAuthorPostType->id,
            'characterAuthors' => $authors->get('characterAuthorsArr'),
            'userAuthors' => $authors->get('userAuthorsArr'),
        ])->assertSet('canAddAuthors', false);
    });

    test('excludes already selected authors from filtered lists', function () {
        $this->post->characterAuthors()->attach($this->singleUserCharacter, ['user_id' => $this->user->id]);
        $this->post->refresh();

        $authors = livewire(PostAuthors::class, ['post' => $this->post]);

        livewire(PostAuthorsEditor::class, [
            'postId' => $this->post->id,
            'postTypeId' => $this->postType->id,
            'characterAuthors' => $authors->get('characterAuthorsArr'),
            'userAuthors' => $authors->get('userAuthorsArr'),
        ])
            ->assertViewHas(
                'filteredCharacters',
                fn (EloquentCollection $characters): bool => $characters->where('id', $this->singleUserCharacter->id)->isEmpty()
            )
            ->assertViewHas(
                'filteredUsers',
                fn (EloquentCollection $users): bool => $users->where('id', $this->user->id)->isEmpty()
            );
    });
});
