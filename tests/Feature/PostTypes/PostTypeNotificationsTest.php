<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;
use Nova\Foundation\Models\NotificationType;
use Nova\Stories\Actions\UpdatePostStatus;
use Nova\Stories\Data\Options;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Notifications\PostPublished;
use Nova\Users\Models\User;

uses()->group('post-types', 'storytelling');

test('publishing a post notifies active users when post type notifications are enabled', function () {
    Notification::fake();

    $activeUsers = User::factory()->active()->count(2)->create();
    $inactiveUser = User::factory()->inactive()->create();

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

    $post = Post::factory()->create([
        'post_type_id' => $postType->id,
        'status' => Draft::class,
        'published_at' => null,
    ]);

    UpdatePostStatus::run($post, PostStatusData::from('published'));

    foreach ($activeUsers as $user) {
        Notification::assertSentTo($user, PostPublished::class);
    }

    Notification::assertNotSentTo($inactiveUser, PostPublished::class);
});

test('publishing a post does not notify anyone when notifications are disabled for the post type', function () {
    Notification::fake();

    $postType = PostType::factory()->create([
        'options' => Options::from(
            notifiesUsers: false,
            includedInPostTracking: true,
            allowsMultipleAuthors: true,
            allowsCharacterAuthors: true,
            allowsUserAuthors: true,
            showContentInTimelineView: false,
            editTimeframe: PostEditTimeframe::Hour4,
        ),
    ]);

    $post = Post::factory()->create([
        'post_type_id' => $postType->id,
        'status' => Draft::class,
        'published_at' => null,
    ]);

    UpdatePostStatus::run($post, PostStatusData::from('published'));

    Notification::assertNothingSent();
});

test('post published notifications include post type details', function () {
    Notification::fake();

    $user = User::factory()->active()->create();

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

    $post = Post::factory()->create([
        'post_type_id' => $postType->id,
        'status' => Draft::class,
        'published_at' => null,
    ]);

    UpdatePostStatus::run($post, PostStatusData::from('published'));

    Notification::assertSentTo($user, PostPublished::class, function (PostPublished $notification, array $channels, object $notifiable) use ($post, $postType): bool {
        $data = $notification->toArray($notifiable);

        return $data['post_id'] === $post->id
            && $data['post_type_name'] === $postType->name
            && $data['post_type_icon'] === $postType->icon
            && $data['post_type_color'] === $postType->color;
    });
});

test('publishing a post respects individual notification preferences', function () {
    Notification::fake();

    $notificationType = NotificationType::where('key', 'post-published')->firstOrFail();

    $enabledUser = User::factory()->active()->create();
    $disabledUser = User::factory()->active()->create();

    $notificationType->preferenceForUser($enabledUser)->update([
        'database' => true,
        'mail' => false,
        'discord' => false,
    ]);

    $notificationType->preferenceForUser($disabledUser)->update([
        'database' => false,
        'mail' => false,
        'discord' => false,
    ]);

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

    $post = Post::factory()->create([
        'post_type_id' => $postType->id,
        'status' => Draft::class,
        'published_at' => null,
    ]);

    UpdatePostStatus::run($post, PostStatusData::from('published'));

    Notification::assertSentTo($enabledUser, PostPublished::class);
    Notification::assertNotSentTo($disabledUser, PostPublished::class);
});
