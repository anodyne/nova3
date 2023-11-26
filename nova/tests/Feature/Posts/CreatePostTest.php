<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Nova\Stories\Actions\CreateRootPost;
use Nova\Stories\Events\PostCreated;
use Nova\Stories\Livewire\ComposePost;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

beforeEach(function () {
    $this->markTestSkipped();

    app(CreateRootPost::class)->execute(
        Story::factory()->current()->create()
    );
});
test('authorized user can view the create post page', function () {
    $this->signInWithPermission('post.create');

    $response = $this->get(route('posts.create'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('posts:compose');
});
test('authorized user can create a post', function () {
    $this->signInWithPermission('post.create');

    Livewire::test(ComposePost::class, [
        'allPostTypes' => $postTypes = PostType::get(),
        'allStories' => Story::current()->get(),
    ])->set('postType', $postTypes->first())
        ->set('title', 'title')
        ->set('day', 'day')
        ->set('time', 'time')
        ->set('location', 'location')
        ->set('content', 'content')
        ->call('publish');

    $this->assertDatabaseHas('posts', [
        'title' => 'title',
        'day' => 'day',
        'time' => 'time',
        'location' => 'location',
        'content' => 'content',
    ]);
});
test('event is dispatched when post is created', function () {
    Event::fake();

    $this->signInWithPermission('post.create');

    Livewire::test(ComposePost::class, [
        'allPostTypes' => $postTypes = PostType::get(),
        'allStories' => Story::current()->get(),
    ])->set('postType', $postTypes->first())
        ->set('title', 'title')
        ->set('day', 'day')
        ->set('time', 'time')
        ->set('location', 'location')
        ->set('content', 'content')
        ->call('publish');

    Event::assertDispatched(PostCreated::class);
});
test('unauthorized user cannot view the create post page', function () {
    $this->signIn();

    $response = $this->get(route('posts.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create a post', function () {
    $this->signIn();

    Livewire::test(ComposePost::class, [
        'allPostTypes' => $postTypes = PostType::get(),
        'allStories' => Story::current()->get(),
    ])->set('postType', $postTypes->first())
        ->set('title', 'title')
        ->set('day', 'day')
        ->set('time', 'time')
        ->set('location', 'location')
        ->set('content', 'content')
        ->call('publish')
        ->assertForbidden();
});
test('unauthenticated user cannot view the create post page', function () {
    $response = $this->getJson(route('posts.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a post', function () {
    Livewire::test(ComposePost::class, [
        'allPostTypes' => $postTypes = PostType::get(),
        'allStories' => Story::current()->get(),
    ])->set('postType', $postTypes->first())
        ->set('title', 'title')
        ->set('day', 'day')
        ->set('time', 'time')
        ->set('location', 'location')
        ->set('content', 'content')
        ->call('publish')
        ->assertForbidden();
});
