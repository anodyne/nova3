<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryUpdated;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;

beforeEach(function () {
    $this->story = Story::factory()->create();
});
test('authorized user can view the edit story page', function () {
    $this->signInWithPermission('story.update');

    $response = $this->get(route('stories.edit', $this->story));
    $response->assertSuccessful();
});
test('authorized user can update a story', function () {
    $this->signInWithPermission('story.update');

    $story = Story::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('stories.update', $this->story),
        array_merge($story->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('title'));

    $this->assertRouteUsesFormRequest(
        'stories.update',
        UpdateStoryRequest::class
    );
});
test('event is dispatched when story is updated', function () {
    Event::fake();

    $this->signInWithPermission('story.update');

    $this->put(
        route('stories.update', $this->story),
        array_merge(Story::factory()->make()->toArray(), [
            'status' => 'upcoming',
        ])
    );

    Event::assertDispatched(StoryUpdated::class);
});
test('required inputs are required', function ($field) {
    $this->signInWithPermission('story.update');

    $data = Story::factory()->make();

    $response = $this->putJson(
        route('stories.update', $this->story),
        array_merge($data->toArray(), [$field => ''])
    );
    $response->assertStatus(422);
    $response->assertJsonValidationErrors($field);
})->with(['title']);
test('unauthorized user cannot view the edit story page', function () {
    $this->signIn();

    $response = $this->get(route('stories.edit', $this->story));
    $response->assertNotFound();
});
test('unauthorized user cannot update a story', function () {
    $this->signIn();

    $response = $this->putJson(
        route('stories.update', $this->story),
        array_merge(Story::factory()->make()->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the edit story page', function () {
    $response = $this->getJson(route('stories.edit', $this->story));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update a story', function () {
    $response = $this->putJson(
        route('stories.update', $this->story),
        array_merge(Story::factory()->make()->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertUnauthorized();
});
