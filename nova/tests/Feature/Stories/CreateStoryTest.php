<?php

declare(strict_types=1);

namespace Tests\Feature\Stories;

use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryCreated;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\CreateStoryRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class CreateStoryTest extends TestCase
{
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
    }

    /** @test **/
    public function upcomingStoryCanBeCreated()
    {
        $this->signInWithPermission('story.create');

        $story = Story::factory()->upcoming()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('stories.store'),
            $story->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('stories', $story->only('status'));
    }

    /** @test **/
    public function currentStoryCanBeCreated()
    {
        $this->signInWithPermission('story.create');

        $story = Story::factory()->current()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('stories.store'),
            $story->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('stories', $story->only('status'));
    }

    /** @test **/
    public function completedStoryCanBeCreated()
    {
        $this->signInWithPermission('story.create');

        $story = Story::factory()->completed()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('stories.store'),
            $story->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('stories', $story->only('status'));
    }

    /** @test **/
    public function ongoingStoryCanBeCreated()
    {
        $this->signInWithPermission('story.create');

        $story = Story::factory()->ongoing()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('stories.store'),
            $story->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('stories', $story->only('status'));
    }

    /** @test **/
    public function storyCanBeCreatedWithSpecificParentStory()
    {
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
    }

    /** @test **/
    public function storyCanBeCreatedWithSpecificSortOrder()
    {
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
    }

    /** @test **/
    public function eventIsDispatchedWhenStoryIsCreated()
    {
        $this->withoutExceptionHandling();
        Event::fake();

        $this->signInWithPermission('story.create');

        $this->post(
            route('stories.store'),
            Story::factory()->upcoming()->make()->toArray()
        );

        Event::assertDispatched(StoryCreated::class);
    }

    /** @test **/
    #[DataProvider('additionProvider')]
    public function requiredInputsAreRequired($field)
    {
        $this->signInWithPermission('story.create');

        $data = Story::factory()->make();

        $response = $this->postJson(route('stories.store'), array_merge($data->toArray(), [
            $field => '',
        ]));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateStoryPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.create'));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateAStory()
    {
        $this->signIn();

        $response = $this->postJson(
            route('stories.store'),
            array_merge(Story::factory()->make()->toArray(), [
                'status' => 'upcoming',
            ])
        );
        $response->assertNotFound();
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
            array_merge(Story::factory()->make()->toArray(), [
                'status' => 'upcoming',
            ])
        );
        $response->assertUnauthorized();
    }

    public static function clientFormValidationProvider(): array
    {
        return [
            ['title'],
        ];
    }
}
