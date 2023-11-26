<?php

declare(strict_types=1);
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});
test('authorized user can view a post type', function () {
    $this->signInWithPermission('post-type.view');

    $response = $this->get(route('post-types.show', $this->postType));
    $response->assertSuccessful();
    $response->assertViewHas('postType', $this->postType);
});
test('unauthorized user cannot view a post type', function () {
    $this->signIn();

    $response = $this->get(route('post-types.show', $this->postType));
    $response->assertNotFound();
});
test('unauthenticated user cannot view a post type', function () {
    $response = $this->getJson(route('post-types.show', $this->postType));
    $response->assertUnauthorized();
});
