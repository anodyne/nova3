<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeCreated;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\CreatePostTypeRequest;
test('authorized user can view the create post type page', function () {
    $this->signInWithPermission('post-type.create');

    $response = $this->get(route('post-types.create'));
    $response->assertSuccessful();
});
test('authorized user can create post type', function () {
    $this->withoutExceptionHandling();
    $this->signInWithPermission('post-type.create');

    $postType = PostType::factory()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('post-types.store'),
        array_merge($postType->toArray(), [
            'status' => 'active',
        ])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('post_types', $postType->only('name', 'key'));

    $this->assertRouteUsesFormRequest(
        'post-types.store',
        CreatePostTypeRequest::class
    );
});
test('event is dispatched when post type is created', function () {
    Event::fake();

    $this->signInWithPermission('post-types.create');

    $this->post(
        route('post-types.store'),
        PostType::factory()->make()->toArray()
    );

    Event::assertDispatched(PostTypeCreated::class);
});
test('unauthorized user cannot view the create post type page', function () {
    $this->signIn();

    $response = $this->get(route('post-types.create'));
    $response->assertNotFound();
});
test('unauthorized user cannot create post type', function () {
    $this->signIn();

    $response = $this->postJson(
        route('post-types.store'),
        PostType::factory()->make()->toArray()
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the create post type page', function () {
    $response = $this->getJson(route('post-types.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create post type', function () {
    $response = $this->postJson(
        route('post-types.store'),
        PostType::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
