<?php

namespace Tests\Feature\Stories;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryCreated;
use Nova\Stories\Requests\CreateStoryRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class CreateStoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateStoryPage()
    {
        $this->signInWithPermission('story.create');

        $response = $this->get(route('stories.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateAStory()
    {
        $this->signInWithPermission('story.create');

        $story = make(Story::class);

        $this->followingRedirects();

        $response = $this->post(
            route('stories.store'),
            $story->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('stories', $story->only('title'));

        $this->assertRouteUsesFormRequest(
            'stories.store',
            CreateStoryRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenStoryIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('story.create');

        $this->post(route('stories.store'), make(Story::class)->toArray());

        Event::assertDispatched(StoryCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateStoryPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateAStory()
    {
        $this->signIn();

        $response = $this->postJson(
            route('stories.store'),
            make(Story::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateStoryPage()
    {
        $response = $this->getJson(route('stories.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateAStory()
    {
        $response = $this->postJson(
            route('stories.store'),
            make(Story::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
