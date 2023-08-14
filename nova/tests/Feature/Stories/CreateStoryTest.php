<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryCreated;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\CreateStoryRequest;

test('authorized user can view the create story page', function () {
    $this->signInWithPermission('story.create');

    $response = $this->get(route('stories.create'));
    $response->assertSuccessful();
});
test('authorized user can create a story', function () {
    $this->signInWithPermission('story.create');

    $story = Story::factory()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        array_merge($story->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('title'));

    $this->assertRouteUsesFormRequest(
        'stories.store',
        CreateStoryRequest::class
    );
});
test('upcoming story can be created', function () {
    $this->signInWithPermission('story.create');

    $story = Story::factory()->upcoming()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        $story->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('status'));
});
test('current story can be created', function () {
    $this->signInWithPermission('story.create');

    $story = Story::factory()->current()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        $story->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('status'));
});
test('completed story can be created', function () {
    $this->signInWithPermission('story.create');

    $story = Story::factory()->completed()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        $story->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('status'));
});
test('ongoing story can be created', function () {
    $this->signInWithPermission('story.create');

    $story = Story::factory()->ongoing()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        $story->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', $story->only('status'));
});
test('story can be created with specific parent story', function () {
    $this->signInWithPermission('story.create');

    $parent = Story::factory()->create();

    $story = Story::factory()->withParent($parent)->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        $story->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', [
        'parent_id' => $parent->id,
    ]);
});
test('story can be created with specific sort order', function () {
    $this->signInWithPermission('story.create');

    $sibling = Story::factory()->create();

    $this->assertDatabaseHas('stories', [
        'title' => $sibling->title,
        'order_column' => 1,
    ]);

    $story = Story::factory()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('stories.store'),
        array_merge($story->toArray(), [
            'display_direction' => 'before',
            'display_neighbor' => $sibling->id,
            'has_position_change' => '1',
        ])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('stories', [
        'title' => $story->title,
        'order_column' => 1,
    ]);

    $this->assertDatabaseHas('stories', [
        'title' => $sibling->title,
        'order_column' => 2,
    ]);
});
test('event is dispatched when story is created', function () {
    $this->withoutExceptionHandling();
    Event::fake();

    $this->signInWithPermission('story.create');

    $this->post(
        route('stories.store'),
        Story::factory()->upcoming()->make()->toArray()
    );

    Event::assertDispatched(StoryCreated::class);
});
test('required inputs are required', function ($field) {
    $this->signInWithPermission('story.create');

    $data = Story::factory()->make();

    $response = $this->postJson(route('stories.store'), array_merge($data->toArray(), [
        $field => '',
    ]));
    $response->assertStatus(422);
    $response->assertJsonValidationErrors($field);
})->with(['title']);
test('unauthorized user cannot view the create story page', function () {
    $this->signIn();

    $response = $this->get(route('stories.create'));
    $response->assertNotFound();
});
test('unauthorized user cannot create a story', function () {
    $this->signIn();

    $response = $this->postJson(
        route('stories.store'),
        array_merge(Story::factory()->make()->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot view the create story page', function () {
    $response = $this->getJson(route('stories.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create a story', function () {
    $response = $this->postJson(
        route('stories.store'),
        array_merge(Story::factory()->make()->toArray(), [
            'status' => 'upcoming',
        ])
    );
    $response->assertUnauthorized();
});
