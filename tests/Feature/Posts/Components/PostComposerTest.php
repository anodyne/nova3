<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Nova\Characters\Models\Character;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Livewire\PostAuthors;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Livewire\PostDetails;
use Nova\Stories\Livewire\PostPosition;
use Nova\Stories\Livewire\PostRatings;
use Nova\Stories\Livewire\PostSummary;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\PostSaved;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->user = createUser(permissions: ['post.create', 'post.delete']);

    $this->story = Story::factory()->current()->create();

    $this->postType = PostType::factory()->create([
        'fields' => Fields::from([
            'title' => Field::from(enabled: true, required: true),
            'day' => Field::from(enabled: true, required: true),
            'time' => Field::from(enabled: true, required: true),
            'location' => Field::from(enabled: true, required: true),
            'content' => Field::from(enabled: true, required: true),
            'rating' => Field::from(enabled: false, required: false),
            'summary' => Field::from(enabled: false, required: false),
        ]),
    ]);

    $this->post = Post::factory()
        ->draft()
        ->withStory($this->story)
        ->create([
            'post_type_id' => $this->postType->id,
            'day' => 'Day 1',
            'time' => '0800 hours',
        ]);
    $this->post->characterAuthors()->detach();
    $this->post->userAuthors()->sync([
        $this->user->id => ['user_id' => $this->user->id, 'as' => null],
    ]);

    $this->post->refresh();
});

test('component mounts with post context', function () {
    signInAs($this->user);

    livewire(PostComposer::class, ['post' => $this->post])
        ->assertOk()
        ->assertSet('post.id', $this->post->id)
        ->assertSet('postTypeId', $this->postType->id)
        ->assertSet('storyId', $this->story->id);
});

test('receiving an update from a child component updates the timestamp', function () {
    signInAs($this->user);

    $component = livewire(PostComposer::class, ['post' => $this->post])
        ->call('handleUpdateFromChild');

    expect($component->get('lastUpdate'))->not->toBeNull();
    expect($component->get('isDirty'))->toBeTrue();
});

test('can change the story', function () {
    $newStory = Story::factory()->current()->create();

    Post::factory()
        ->draft()
        ->withStory($newStory)
        ->create([
            'post_type_id' => $this->postType->id,
        ]);

    signInAs($this->user);

    livewire(PostComposer::class, ['post' => $this->post])
        ->call('changeStory', $newStory->id)
        ->assertRedirect(route('admin.posts.edit', $this->post));

    $this->post->refresh();

    expect($this->post->story_id)->toBe($newStory->id);
});

test('can change the post type', function () {
    $oldPostType = PostType::factory()->create([
        'fields' => Fields::from([
            'title' => Field::from(enabled: true, required: true),
            'day' => Field::from(enabled: true, required: true),
            'time' => Field::from(enabled: true, required: true),
            'location' => Field::from(enabled: true, required: true),
            'content' => Field::from(enabled: true, required: true),
            'rating' => Field::from(enabled: true, required: true),
            'summary' => Field::from(enabled: true, required: true),
        ]),
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

    $newPostType = PostType::factory()->create([
        'fields' => Fields::from([
            'title' => Field::from(enabled: true, required: true),
            'day' => Field::from(enabled: false, required: false),
            'time' => Field::from(enabled: false, required: false),
            'location' => Field::from(enabled: false, required: false),
            'content' => Field::from(enabled: true, required: true),
            'rating' => Field::from(enabled: false, required: false),
            'summary' => Field::from(enabled: false, required: false),
        ]),
        'options' => Options::from(
            notifiesUsers: true,
            includedInPostTracking: true,
            allowsMultipleAuthors: false,
            allowsCharacterAuthors: false,
            allowsUserAuthors: true,
            showContentInTimelineView: false,
            editTimeframe: PostEditTimeframe::Hour4,
        ),
    ]);

    $otherUser = createUser();
    $currentUserCharacter = Character::factory()->active()->create();
    $otherCharacter = Character::factory()->active()->create();

    $currentUserCharacter->users()->attach($this->user->id, ['primary' => true]);
    $otherCharacter->users()->attach($otherUser->id, ['primary' => true]);

    $post = Post::factory()
        ->draft()
        ->withStory($this->story)
        ->create([
            'post_type_id' => $oldPostType->id,
            'day' => 'Day 12',
            'time' => '1300 hours',
            'location' => 'Engineering',
            'summary' => 'Initial summary',
            'rating_language' => ContentRatingValue::Level3,
            'rating_sex' => ContentRatingValue::Level3,
            'rating_violence' => ContentRatingValue::Level3,
        ]);

    $post->userAuthors()->detach();
    $post->characterAuthors()->sync([
        $currentUserCharacter->id => ['user_id' => $this->user->id],
        $otherCharacter->id => ['user_id' => $otherUser->id],
    ]);

    signInAs($this->user);

    $component = livewire(PostComposer::class, ['post' => $post])
        ->call('startPostTypeChange', $newPostType->id)
        ->assertDispatched('modal.open')
        ->dispatch('actionConfirmed')
        ->assertRedirect(route('admin.posts.edit', $post));

    $post->refresh()->load('characterAuthors', 'userAuthors');

    expect($post->post_type_id)->toBe($newPostType->id);
    expect($post->day)->toBeNull();
    expect($post->time)->toBeNull();
    expect($post->location)->toBeNull();
    expect($post->summary)->toBeNull();
    expect($post->rating_language)->toBe(settings('ratings.language.rating'));
    expect($post->rating_sex)->toBe(settings('ratings.sex.rating'));
    expect($post->rating_violence)->toBe(settings('ratings.violence.rating'));
    expect($post->characterAuthors)->toHaveCount(0);
    expect($post->userAuthors->pluck('id'))->toContain($this->user->id);
});

describe('save post', function () {
    test('published post can be saved and dispatches save events', function () {
        $publishedPost = Post::factory()
            ->published()
            ->withStory($this->story)
            ->create([
                'post_type_id' => $this->postType->id,
                'day' => 'Day 1',
                'time' => '0800 hours',
            ]);

        $publishedPost->characterAuthors()->detach();
        $publishedPost->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
        ]);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $publishedPost])
            ->assertSeeText('Update')
            ->call('save')
            ->assertDispatchedTo(PostDetails::class, 'save-post')
            ->assertDispatchedTo(PostAuthors::class, 'save-post')
            ->assertDispatchedTo(PostPosition::class, 'save-post')
            ->assertSet('saveSilently', false);
    });

    test('save dispatches save events to child components and resets dirty state', function () {
        $component = Livewire::actingAs($this->user)
            ->test(PostComposer::class, ['post' => $this->post])
            ->call('handleUpdateFromChild');

        expect($component->get('isDirty'))->toBeTrue();

        $component->call('save')
            ->assertDispatchedTo(PostDetails::class, 'save-post')
            ->assertDispatchedTo(PostAuthors::class, 'save-post')
            ->assertDispatchedTo(PostPosition::class, 'save-post');

        expect($component->get('saveSilently'))->toBeFalse();
        expect($component->get('savedChildrenCount'))->toBe(0);
        expect($component->get('lastUpdate'))->toBeNull();
        expect($component->get('isDirty'))->toBeFalse();
    });

    test('save dispatches to ratings and summary child components when enabled by post type', function () {
        $postTypeWithRatingsAndSummary = PostType::factory()->create([
            'fields' => Fields::from([
                'title' => Field::from(enabled: true, required: true),
                'day' => Field::from(enabled: true, required: true),
                'time' => Field::from(enabled: true, required: true),
                'location' => Field::from(enabled: true, required: true),
                'content' => Field::from(enabled: true, required: true),
                'rating' => Field::from(enabled: true, required: true),
                'summary' => Field::from(enabled: true, required: true),
            ]),
        ]);

        $post = Post::factory()
            ->draft()
            ->withStory($this->story)
            ->create([
                'post_type_id' => $postTypeWithRatingsAndSummary->id,
                'day' => 'Day 1',
                'time' => '0800 hours',
            ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
        ]);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $post])
            ->call('save')
            ->assertDispatchedTo(PostDetails::class, 'save-post')
            ->assertDispatchedTo(PostAuthors::class, 'save-post')
            ->assertDispatchedTo(PostRatings::class, 'save-post')
            ->assertDispatchedTo(PostSummary::class, 'save-post')
            ->assertDispatchedTo(PostPosition::class, 'save-post');
    });

    test('open for publishing saves silently and opens publish slide over', function () {
        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post])
            ->call('handleUpdateFromChild')
            ->assertSet('isDirty', true)
            ->call('openForPublishing')
            ->assertSet('saveSilently', true)
            ->assertSet('isDirty', false)
            ->assertDispatchedTo(PostDetails::class, 'save-post')
            ->assertDispatchedTo(PostAuthors::class, 'save-post')
            ->assertDispatchedTo(PostPosition::class, 'save-post')
            ->assertDispatched('slide-over.open', function (string $event, array $params): bool {
                $component = data_get($params, 'component') ?? data_get($params, '0.component');
                $postId = data_get($params, 'arguments.postId') ?? data_get($params, '0.arguments.postId');

                return $event === 'slide-over.open'
                    && $component === 'posts-publish'
                    && $postId === $this->post->id;
            });
    });

    test('check all saved notifies other participants when save is not silent', function () {
        Notification::fake();

        $otherUser = createUser();

        $this->post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
            $otherUser->id => ['user_id' => $otherUser->id, 'as' => null],
        ]);
        $this->post->refresh();

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post])
            ->call('save')
            ->call('checkAllSaved')
            ->call('checkAllSaved')
            ->call('checkAllSaved')
            ->assertSet('savedChildrenCount', 0);

        Notification::assertSentTo($otherUser, PostSaved::class);
        Notification::assertNotSentTo($this->user, PostSaved::class);
    });

    test('check all saved does not notify participants when save is silent', function () {
        Notification::fake();

        $otherUser = createUser();

        $this->post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
            $otherUser->id => ['user_id' => $otherUser->id, 'as' => null],
        ]);
        $this->post->refresh();

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post])
            ->call('save', true)
            ->call('checkAllSaved')
            ->call('checkAllSaved')
            ->call('checkAllSaved')
            ->assertSet('savedChildrenCount', 0);

        Notification::assertNothingSent();
    });

    test('save and finish saves silently and redirects to writing overview', function () {
        $this->post->lock($this->user);
        $this->post->refresh();

        Livewire::actingAs($this->user)
            ->test(PostComposer::class, ['post' => $this->post])
            ->call('saveAndFinish', true)
            ->assertSet('saveSilently', true)
            ->assertDispatchedTo(PostDetails::class, 'save-post')
            ->assertDispatchedTo(PostAuthors::class, 'save-post')
            ->assertDispatchedTo(PostPosition::class, 'save-post')
            ->assertRedirect(route('admin.writing-overview'));

        $this->post->refresh();

        expect($this->post->locked_by)->toBeNull();
        expect($this->post->locked_at)->toBeNull();
    });
});

describe('publish post', function () {
    test('shows validation guidance when publish requirements are not met', function () {
        $this->post->update([
            'title' => null,
        ]);

        Livewire::actingAs($this->user)
            ->test(PostComposer::class, ['post' => $this->post])
            ->assertSeeText('please add');
    });

    test('can publish is true for a valid post and clears validation errors', function () {
        $component = Livewire::actingAs($this->user)
            ->test(PostComposer::class, ['post' => $this->post]);

        expect($component->get('canPublish'))->toBeTrue();
        expect($component->get('validationErrors'))->toBeNull();
    });
});

describe('delete post', function () {
    test('can delete a published post after confirming the action', function () {
        $post = Post::factory()
            ->published()
            ->withStory($this->story)
            ->create([
                'post_type_id' => $this->postType->id,
                'day' => 'Day 1',
                'time' => '0800 hours',
            ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
        ]);

        $component = Livewire::actingAs($this->user)
            ->test(PostComposer::class, ['post' => $post])
            ->call('delete')
            ->assertDispatched('modal.open');

        $component->dispatch('actionConfirmed')
            ->assertRedirect(route('admin.writing-overview'));

        assertSoftDeleted(Post::class, ['id' => $post->id]);
        assertDatabaseMissing(PostAuthor::class, ['post_id' => $post->id]);
    });
});

describe('discard draft post', function () {
    test('can discard a draft post after confirming the action', function () {
        $post = Post::factory()
            ->draft()
            ->withStory($this->story)
            ->create([
                'post_type_id' => $this->postType->id,
                'day' => 'Day 1',
                'time' => '0800 hours',
            ]);

        $post->characterAuthors()->detach();
        $post->userAuthors()->sync([
            $this->user->id => ['user_id' => $this->user->id, 'as' => null],
        ]);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $post])
            ->call('discard')
            ->assertDispatched('modal.open')
            ->dispatch('actionConfirmed')
            ->assertRedirect(route('admin.writing-overview'));

        assertDatabaseMissing(Post::class, ['id' => $post->id]);
        assertDatabaseMissing(PostAuthor::class, ['post_id' => $post->id]);
    });
});

describe('post locking', function () {
    test('mounting locks the post when there is more than one participant', function () {
        $otherUser = createUser();

        $this->post->userAuthors()->detach();
        $this->post->userAuthors()->attach($this->user->id, ['user_id' => $this->user->id, 'as' => null]);
        $this->post->userAuthors()->attach($otherUser->id, ['user_id' => $otherUser->id, 'as' => null]);

        expect($this->post->participatingUsers()->count())->toBe(2);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post]);

        $this->post->refresh();

        expect($this->post->isLocked())->toBeTrue();
        expect($this->post->locked_by)->toBe($this->user->id);
    });

    test('mounting does not lock the post when there is only one participant', function () {
        expect($this->post->participatingUsers()->count())->toBe(1);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post]);

        $this->post->refresh();

        expect($this->post->isLocked())->toBeFalse();
        expect($this->post->locked_by)->toBeNull();
    });

    test('renders the locked post state when another user owns the lock', function () {
        $otherUser = createUser();

        $this->post->lock($otherUser);

        signInAs($this->user);

        livewire(PostComposer::class, ['post' => $this->post])
            ->assertSeeText('Post locked');
    });
});
