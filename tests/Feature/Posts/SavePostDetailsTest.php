<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Nova\Stories\Actions\SavePostDetails;
use Nova\Stories\Actions\UpdateContributorData;
use Nova\Stories\Actions\UpdateContributorWordCount;
use Nova\Stories\Actions\UpdatePost;
use Nova\Stories\Data\PostDetailsData;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;

use function Pest\Laravel\assertDatabaseHas;

uses()->group('posts', 'storytelling', 'actions');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create([
        'content' => '<p>One two three</p>',
        'participants' => [],
    ]);
    $this->user = createUser();
    $this->post->userAuthors()->attach($this->user, [
        'user_id' => $this->user->id,
        'word_count' => 10,
    ]);
    $this->data = PostDetailsData::from(
        content: '<p>One two three four five</p>',
        title: 'Updated title',
        day: null,
        time: null,
        location: null,
    );
});

it('saves details and credits the explicit actor without authentication', function () {
    expect(Auth::user())->toBeNull();

    $post = SavePostDetails::run($this->post->id, $this->data, $this->user);

    expect($post->word_count)->toBe(5);
    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'title' => 'Updated title',
        'word_count' => 5,
        'last_update_by' => $this->user->id,
    ]);
    expect($post->participants)->toContain($this->user->id);
    assertDatabaseHas(PostAuthor::class, [
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'word_count' => 12,
    ]);
});

it('does not credit the same content twice', function () {
    SavePostDetails::run($this->post->id, $this->data, $this->user);
    $participants = $this->post->fresh()->participants;

    SavePostDetails::run($this->post->id, $this->data, $this->user);

    assertDatabaseHas(PostAuthor::class, [
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'word_count' => 12,
    ]);
    expect($this->post->fresh()->participants)->toBe($participants);
});

it('uses the explicit actor instead of the authenticated user', function () {
    signIn();

    SavePostDetails::run($this->post->id, $this->data, $this->user);

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'last_update_by' => $this->user->id,
    ]);
});

it('updates contributor metadata for edits with the same word count', function () {
    $data = PostDetailsData::from(content: '<p>Four five six</p>', title: null, day: null, time: null, location: null);

    SavePostDetails::run($this->post->id, $data, $this->user);

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'content' => '<p>Four five six</p>',
        'word_count' => 3,
        'last_update_by' => $this->user->id,
    ]);
    assertDatabaseHas(PostAuthor::class, [
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'word_count' => 10,
    ]);
});

it('updates metadata without removing credit when content shrinks or is cleared', function (?string $content, int $wordCount) {
    $data = PostDetailsData::from(content: $content, title: null, day: null, time: null, location: null);

    SavePostDetails::run($this->post->id, $data, $this->user);

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'content' => $content,
        'word_count' => $wordCount,
        'last_update_by' => $this->user->id,
    ]);
    assertDatabaseHas(PostAuthor::class, [
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'word_count' => 10,
    ]);
})->with([
    'reduction' => ['<p>One</p>', 1],
    'cleared' => [null, 0],
]);

it('preserves contributor metadata when only the title changes', function () {
    $original = $this->post->fresh();
    $data = PostDetailsData::from(content: $original->content, title: 'Title only', day: null, time: null, location: null);

    SavePostDetails::run($original->id, $data, $this->user);

    $saved = $original->fresh();
    expect($saved->participants)->toBe($original->participants);
    assertDatabaseHas(Post::class, [
        'id' => $original->id,
        'title' => 'Title only',
        'word_count' => 3,
        'last_update_by' => $original->last_update_by,
    ]);
});

it('rolls back details when the credited contributor is missing', function () {
    $this->post->userAuthors()->detach($this->user);
    $original = $this->post->fresh();

    expect(fn () => SavePostDetails::run($original->id, $this->data, $this->user))
        ->toThrow(ModelNotFoundException::class);

    assertDatabaseHas(Post::class, [
        'id' => $original->id,
        'title' => $original->title,
        'content' => $original->content,
        'word_count' => $original->word_count,
        'last_update_by' => $original->last_update_by,
    ]);
    expect($original->fresh()->participants)->toBe($original->participants);
});

it('prepares contributor attributes without persisting them', function () {
    $original = $this->post->fresh();
    $this->post->content = '<p>New content</p>';

    UpdateContributorData::run($this->post, $this->user);

    expect($this->post->word_count)->toBe(2);
    expect($this->post->last_update_by)->toBe($this->user->id);
    expect($this->post->participants)->toContain($this->user->id);
    assertDatabaseHas(Post::class, ['id' => $original->id, 'content' => $original->content]);
});

it('updates content through the reusable post action', function () {
    UpdatePost::run($this->post, $this->data, $this->user);

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'content' => $this->data->content,
        'word_count' => 5,
        'last_update_by' => $this->user->id,
    ]);
});

it('does not query authorships for a nonpositive credit', function (int $wordCountDiff) {
    $this->expectsDatabaseQueryCount(0);

    UpdateContributorWordCount::run($this->post, $this->user, $wordCountDiff);
})->with([0, -2]);

it('credits only one authorship when a user has multiple authorships', function () {
    $authorships = PostAuthor::query()->wherePost($this->post)->get();
    foreach ($authorships as $authorship) {
        $authorship->update(['user_id' => $this->user->id, 'word_count' => 10]);
    }
    $originalCount = PostAuthor::query()->wherePost($this->post)->sum('word_count');

    SavePostDetails::run($this->post->id, $this->data, $this->user);

    expect((int) PostAuthor::query()->wherePost($this->post)->sum('word_count'))->toBe((int) $originalCount + 2);
});
