<?php

declare(strict_types=1);

namespace Tests\Feature\Stories;

use Illuminate\Support\Facades\Event;
use Nova\Stories\Events\StoryUpdated;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * @group storytelling
 * @group stories
 */
class UpdateStoryTest extends TestCase
{
    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditStoryPage()
    {
        $this->signInWithPermission('story.update');

        $response = $this->get(route('stories.edit', $this->story));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateAStory()
    {
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
    }

    /** @test **/
    public function eventIsDispatchedWhenStoryIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('story.update');

        $this->put(
            route('stories.update', $this->story),
            array_merge(Story::factory()->make()->toArray(), [
                'status' => 'upcoming',
            ])
        );

        Event::assertDispatched(StoryUpdated::class);
    }

    /** @test **/
    #[DataProvider('additionProvider')]
    public function requiredInputsAreRequired($field)
    {
        $this->signInWithPermission('story.update');

        $data = Story::factory()->make();

        $response = $this->putJson(
            route('stories.update', $this->story),
            array_merge($data->toArray(), [$field => ''])
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditStoryPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.edit', $this->story));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateAStory()
    {
        $this->signIn();

        $response = $this->putJson(
            route('stories.update', $this->story),
            array_merge(Story::factory()->make()->toArray(), [
                'status' => 'upcoming',
            ])
        );
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditStoryPage()
    {
        $response = $this->getJson(route('stories.edit', $this->story));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateAStory()
    {
        $response = $this->putJson(
            route('stories.update', $this->story),
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
