<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\PostTypeDeleted;
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
test('authorized user can delete post type', function () {
    $this->signInWithPermission('post-type.delete');

    $this->followingRedirects();

    $response = $this->delete(route('post-types.destroy', $this->postType));
    $response->assertSuccessful();

    $this->assertSoftDeleted('post_types', [
        'id' => $this->postType->id,
    ]);
});
test('event is dispatched when post type is deleted', function () {
    Event::fake();

    $this->signInWithPermission('post-type.delete');

    $this->delete(route('post-types.destroy', $this->postType));

    Event::assertDispatched(PostTypeDeleted::class);
});
test('unauthorized user cannot delete post type', function () {
    $this->signIn();

    $response = $this->delete(route('post-types.destroy', $this->postType));
    $response->assertNotFound();
});
test('unauthenticated user cannot delete post type', function () {
    $response = $this->deleteJson(route('post-types.destroy', $this->postType));
    $response->assertUnauthorized();
});
