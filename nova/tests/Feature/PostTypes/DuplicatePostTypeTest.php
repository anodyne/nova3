<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\PostTypeDuplicated;
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create([
        'key' => 'foo',
        'name' => 'Foo',
    ]);
});
test('authorized user can duplicate post type', function () {
    $this->signInWithPermission(['post-type.create', 'post-type.update']);

    $this->followingRedirects();

    $response = $this->post(route('post-types.duplicate', $this->postType));
    $response->assertSuccessful();

    $this->assertDatabaseHas('post_types', [
        'name' => "Copy of {$this->postType->name}",
    ]);
});
test('event is dispatched when post type is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['post-type.create', 'post-type.update']);

    $this->post(route('post-types.duplicate', $this->postType));

    Event::assertDispatched(PostTypeDuplicated::class);
});
test('unauthorized user cannot duplicate post type', function () {
    $this->signIn();

    $response = $this->post(route('post-types.duplicate', $this->postType));
    $response->assertNotFound();
});
test('unauthenticated user cannot duplicate post type', function () {
    $response = $this->postJson(route('post-types.duplicate', $this->postType));
    $response->assertUnauthorized();
});
