<?php

declare(strict_types=1);
use Nova\Stories\Models\Story;
beforeEach(function () {
    $this->story = Story::factory()->create();
});
test('authorized user can view a story', function () {
    $this->signInWithPermission('story.view');

    $response = $this->get(route('stories.show', $this->story));
    $response->assertSuccessful();
    $response->assertViewHas('story', $this->story);
});
test('unauthorized user cannot view a story', function () {
    $this->signIn();

    $response = $this->get(route('stories.show', $this->story));
    $response->assertNotFound();
});
test('unauthenticated user cannot view a story', function () {
    $response = $this->getJson(route('stories.show', $this->story));
    $response->assertUnauthorized();
});
