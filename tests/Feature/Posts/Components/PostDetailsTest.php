<?php

declare(strict_types=1);

use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Livewire\PostDetails;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses()->group('posts', 'storytelling', 'components');

beforeEach(function () {
    $this->post = Post::factory()->draft()->create([
        'title' => 'Post title',
        'location' => 'Post location',
        'day' => 'Day 1',
        'time' => '0900 hours',
        'content' => '',
    ]);

    $this->user = createUser(permissions: 'post.create');

    $this->post->userAuthors()->attach($this->user, ['user_id' => $this->user->id]);
    $this->post->refresh();
});

it('mounts', function () {
    livewire(PostDetails::class, ['post' => $this->post])
        ->assertSet('postId', $this->post->id)
        ->assertSet('postTypeId', $this->post->post_type_id)
        ->assertSet('title', $this->post->title)
        ->assertSet('location', $this->post->location)
        ->assertSet('day', $this->post->day)
        ->assertSet('time', $this->post->time)
        ->assertSet('content', $this->post->content);
});

it('can save post details', function () {
    signInAs($this->user);

    livewire(PostDetails::class, ['post' => $this->post])
        ->set('title', 'New title')
        ->set('location', 'New location')
        ->set('day', 'Day 2')
        ->set('time', '1400 hours')
        ->set('content', '<p>Ipsum esse et est. Eu labore id mollit. Ipsum sint do non excepteur do reprehenderit. Ad incididunt cillum veniam sunt labore ullamco esse duis velit esse proident consectetur dolor consequat non. Ea duis sit enim reprehenderit cillum nisi enim. Ea culpa adipisicing reprehenderit veniam mollit exercitation occaecat tempor proident pariatur cupidatat in laborum. Sint magna laboris reprehenderit qui laborum voluptate enim nostrud eiusmod cillum cillum elit dolor. Velit do aliqua ad fugiat.</p>')
        ->dispatch('save-post')
        ->assertDispatchedTo(PostComposer::class, 'save-post-completed');

    assertDatabaseHas(Post::class, [
        'id' => $this->post->id,
        'title' => 'New title',
        'location' => 'New location',
        'day' => 'Day 2',
        'time' => '1400 hours',
        'content' => '<p>Ipsum esse et est. Eu labore id mollit. Ipsum sint do non excepteur do reprehenderit. Ad incididunt cillum veniam sunt labore ullamco esse duis velit esse proident consectetur dolor consequat non. Ea duis sit enim reprehenderit cillum nisi enim. Ea culpa adipisicing reprehenderit veniam mollit exercitation occaecat tempor proident pariatur cupidatat in laborum. Sint magna laboris reprehenderit qui laborum voluptate enim nostrud eiusmod cillum cillum elit dolor. Velit do aliqua ad fugiat.</p>',
        'word_count' => 72,
    ]);
});

it('sets contributor word count when saved', function () {
    signInAs($this->user);

    $postAuthorPivot = PostAuthor::query()
        ->wherePost($this->post)
        ->whereUser($this->user)
        ->first();

    livewire(PostDetails::class, ['post' => $this->post])
        ->set('title', 'New title')
        ->set('location', 'New location')
        ->set('day', 'Day 2')
        ->set('time', '1400 hours')
        ->set('content', '<p>Ipsum esse et est. Eu labore id mollit. Ipsum sint do non excepteur do reprehenderit. Ad incididunt cillum veniam sunt labore ullamco esse duis velit esse proident consectetur dolor consequat non. Ea duis sit enim reprehenderit cillum nisi enim. Ea culpa adipisicing reprehenderit veniam mollit exercitation occaecat tempor proident pariatur cupidatat in laborum. Sint magna laboris reprehenderit qui laborum voluptate enim nostrud eiusmod cillum cillum elit dolor. Velit do aliqua ad fugiat.</p>')
        ->dispatch('save-post');

    $postAuthorPivot->refresh();

    expect($postAuthorPivot->word_count)->toBe(72);
});

it('updates existing contributor word count when saved', function () {
    signIn(permissions: 'post.create');

    $currentUser = Auth::user();

    $this->post->userAuthors()->attach($currentUser, ['user_id' => $currentUser->id]);
    $this->post->refresh();

    $postAuthorPivot = PostAuthor::query()
        ->wherePost($this->post)
        ->whereUser($currentUser)
        ->first();

    $postAuthorPivot->word_count = 100;
    $postAuthorPivot->save();
    $postAuthorPivot->refresh();

    expect($postAuthorPivot->word_count)->toBe(100);

    livewire(PostDetails::class, ['post' => $this->post])
        ->set('title', 'New title')
        ->set('location', 'New location')
        ->set('day', 'Day 2')
        ->set('time', '1400 hours')
        ->set('content', '<p>Ipsum esse et est. Eu labore id mollit. Ipsum sint do non excepteur do reprehenderit. Ad incididunt cillum veniam sunt labore ullamco esse duis velit esse proident consectetur dolor consequat non. Ea duis sit enim reprehenderit cillum nisi enim. Ea culpa adipisicing reprehenderit veniam mollit exercitation occaecat tempor proident pariatur cupidatat in laborum. Sint magna laboris reprehenderit qui laborum voluptate enim nostrud eiusmod cillum cillum elit dolor. Velit do aliqua ad fugiat.</p>')
        ->dispatch('save-post');

    $postAuthorPivot->refresh();

    expect($postAuthorPivot->word_count)->toBe(172);
});
