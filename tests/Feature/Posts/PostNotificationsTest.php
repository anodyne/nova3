<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\NotificationType;
use Nova\Stories\Actions\DiscardPost;
use Nova\Stories\Actions\UpdatePostAuthors;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Stories\Notifications\CharacterAuthorAddedToPost;
use Nova\Stories\Notifications\CharacterAuthorRemovedFromPost;
use Nova\Stories\Notifications\DraftPostDiscarded;
use Nova\Stories\Notifications\PostSaved;
use Nova\Stories\Notifications\UserAuthorAddedToPost;
use Nova\Stories\Notifications\UserAuthorRemovedFromPost;

use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling');

test('updating post authors sends added and removed author notifications', function () {
    Notification::fake();

    $removedCharacterUser = createUser();
    $addedCharacterUser = createUser();
    $removedUserAuthor = createUser();
    $addedUserAuthor = createUser();

    $removedCharacter = Character::factory()->active()->primary()->create();
    $addedCharacter = Character::factory()->active()->support()->create();

    $removedCharacter->users()->attach($removedCharacterUser->id, ['primary' => true]);
    $addedCharacter->users()->attach($addedCharacterUser->id, ['primary' => true]);

    $story = Story::factory()->current()->create();
    $postType = PostType::factory()->create([
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

    $post = Post::factory()->draft()->withStory($story)->create([
        'post_type_id' => $postType->id,
    ]);

    $post->characterAuthors()->sync([
        $removedCharacter->id => ['user_id' => $removedCharacterUser->id],
    ]);

    $post->userAuthors()->sync([
        $removedUserAuthor->id => ['user_id' => $removedUserAuthor->id, 'as' => null],
    ]);

    $post->refresh()->load('characterAuthors', 'userAuthors');

    UpdatePostAuthors::run($post, PostAuthorsData::from(
        characters: [
            $addedCharacter->id => ['user_id' => $addedCharacterUser->id],
        ],
        originalCharacters: $post->characterAuthors,
        users: [
            $addedUserAuthor->id => ['user_id' => $addedUserAuthor->id, 'as' => 'Guest'],
        ],
        originalUsers: $post->userAuthors,
    ));

    Notification::assertSentTo($addedCharacterUser, CharacterAuthorAddedToPost::class, function (CharacterAuthorAddedToPost $notification, array $channels, object $notifiable) use ($post, $addedCharacter): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $post->postType->name
            && $data['character_name'] === $addedCharacter->name;
    });

    Notification::assertSentTo($addedUserAuthor, UserAuthorAddedToPost::class, function (UserAuthorAddedToPost $notification, array $channels, object $notifiable) use ($post): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $post->postType->name;
    });

    Notification::assertSentTo($removedCharacterUser, CharacterAuthorRemovedFromPost::class, function (CharacterAuthorRemovedFromPost $notification, array $channels, object $notifiable) use ($post, $removedCharacter): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $post->postType->name
            && $data['character_name'] === $removedCharacter->name;
    });

    Notification::assertSentTo($removedUserAuthor, UserAuthorRemovedFromPost::class, function (UserAuthorRemovedFromPost $notification, array $channels, object $notifiable) use ($post): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $post->postType->name;
    });
});

test('updating post authors can skip author notifications', function () {
    Notification::fake();

    $removedCharacterUser = createUser();
    $addedCharacterUser = createUser();
    $removedUserAuthor = createUser();
    $addedUserAuthor = createUser();

    $removedCharacter = Character::factory()->active()->primary()->create();
    $addedCharacter = Character::factory()->active()->support()->create();

    $removedCharacter->users()->attach($removedCharacterUser->id, ['primary' => true]);
    $addedCharacter->users()->attach($addedCharacterUser->id, ['primary' => true]);

    $post = Post::factory()->draft()->create();

    $post->characterAuthors()->sync([
        $removedCharacter->id => ['user_id' => $removedCharacterUser->id],
    ]);

    $post->userAuthors()->sync([
        $removedUserAuthor->id => ['user_id' => $removedUserAuthor->id, 'as' => null],
    ]);

    $post->refresh()->load('characterAuthors', 'userAuthors');

    UpdatePostAuthors::run(
        post: $post,
        data: PostAuthorsData::from(
            characters: [
                $addedCharacter->id => ['user_id' => $addedCharacterUser->id],
            ],
            originalCharacters: $post->characterAuthors,
            users: [
                $addedUserAuthor->id => ['user_id' => $addedUserAuthor->id, 'as' => 'Guest'],
            ],
            originalUsers: $post->userAuthors,
        ),
        sendNotifications: false
    );

    Notification::assertNothingSent();
});

test('saving a post in composer notifies participating users except the editor', function () {
    Notification::fake();

    $editor = createUser(permissions: 'post.create');
    $collaborator = createUser();

    $story = Story::factory()->current()->create();
    $postType = PostType::factory()->create([
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

    $post = Post::factory()->draft()->withStory($story)->create([
        'post_type_id' => $postType->id,
        'day' => 'Day 1',
        'time' => '0900 hours',
    ]);

    $post->characterAuthors()->detach();
    $post->userAuthors()->sync([
        $editor->id => ['user_id' => $editor->id, 'as' => null],
        $collaborator->id => ['user_id' => $collaborator->id, 'as' => null],
    ]);

    signInAs($editor);

    livewire(PostComposer::class, ['post' => $post])
        ->call('save')
        ->call('checkAllSaved')
        ->call('checkAllSaved')
        ->call('checkAllSaved');

    Notification::assertSentTo($collaborator, PostSaved::class, function (PostSaved $notification, array $channels, object $notifiable) use ($post, $editor): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $post->postType->name
            && $data['user_name'] === $editor->name;
    });

    Notification::assertNotSentTo($editor, PostSaved::class);
});

test('silent save does not send post saved notifications', function () {
    Notification::fake();

    $editor = createUser(permissions: 'post.create');
    $collaborator = createUser();

    $postType = PostType::factory()->create([
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

    $post = Post::factory()->draft()->create([
        'post_type_id' => $postType->id,
        'day' => 'Day 1',
        'time' => '0900 hours',
    ]);

    $post->characterAuthors()->detach();
    $post->userAuthors()->sync([
        $editor->id => ['user_id' => $editor->id, 'as' => null],
        $collaborator->id => ['user_id' => $collaborator->id, 'as' => null],
    ]);

    signInAs($editor);

    livewire(PostComposer::class, ['post' => $post])
        ->call('save', true)
        ->call('checkAllSaved')
        ->call('checkAllSaved')
        ->call('checkAllSaved');

    Notification::assertNothingSent();
});

test('discarding a draft post notifies all participants', function () {
    Notification::fake();

    $discardingUser = createUser(permissions: ['post.create', 'post.delete']);
    $participantA = createUser();
    $participantB = createUser();

    $draftDiscardedNotificationType = NotificationType::query()
        ->where('key', 'draft-post-discarded')
        ->firstOrFail();

    collect([$discardingUser, $participantA, $participantB])
        ->each(function ($user) use ($draftDiscardedNotificationType): void {
            $draftDiscardedNotificationType->preferenceForUser($user)->update([
                'database' => true,
                'mail' => false,
                'discord' => false,
            ]);
        });

    $post = Post::factory()->draft()->create();

    $post->characterAuthors()->detach();
    $post->userAuthors()->sync([
        $discardingUser->id => ['user_id' => $discardingUser->id, 'as' => null],
        $participantA->id => ['user_id' => $participantA->id, 'as' => null],
        $participantB->id => ['user_id' => $participantB->id, 'as' => null],
    ]);

    signInAs($discardingUser);

    DiscardPost::run($post);

    Notification::assertSentTo(
        [$discardingUser, $participantA, $participantB],
        DraftPostDiscarded::class,
        function (DraftPostDiscarded $notification, array $channels, object $notifiable) use ($discardingUser, $post): bool {
            $data = $notification->toArray($notifiable);

            return $data['post_id'] === $post->id
                && $data['post_type_name'] === $post->postType->name
                && $data['user_name'] === $discardingUser->name;
        }
    );
});
