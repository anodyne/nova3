<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\PostTypeUpdated;
use Nova\Stories\Models\PostType;
use Nova\Stories\Requests\UpdatePostTypeRequest;

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
test('authorized user can view the edit post type page', function () {
    $this->signInWithPermission('post-type.update');

    $response = $this->get(route('post-types.edit', $this->postType));
    $response->assertSuccessful();
});
test('authorized user can update post type', function () {
    $this->signInWithPermission('post-type.update');

    $this->followingRedirects();

    $postType = PostType::factory()->make();

    $response = $this->put(
        route('post-types.update', $this->postType),
        $postType->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('post_types', $postType->only('name', 'key'));

    $this->assertRouteUsesFormRequest(
        'post-types.update',
        UpdatePostTypeRequest::class
    );
});
test('event is dispatched when post type is updated', function () {
    Event::fake();

    $this->signInWithPermission('post-type.update');

    $this->put(
        route('post-types.update', $this->postType),
        PostType::factory()->make()->toArray()
    );

    Event::assertDispatched(PostTypeUpdated::class);
});
test('unauthorized user cannot view the edit post type page', function () {
    $this->signIn();

    $response = $this->get(route('post-types.edit', $this->postType));
    $response->assertNotFound();
});
test('unauthorized user cannot update post type', function () {
    $this->signIn();

    $response = $this->putJson(
        route('post-types.update', $this->postType),
        PostType::factory()->make()->toArray()
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the edit post type page', function () {
    $response = $this->getJson(route('post-types.edit', $this->postType));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update post type', function () {
    $response = $this->putJson(
        route('post-types.update', $this->postType),
        PostType::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
