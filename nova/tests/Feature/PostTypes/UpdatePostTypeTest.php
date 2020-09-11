<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeUpdated;
use Nova\PostTypes\Requests\UpdatePostTypeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;

/**
 * @group stories
 * @group post-types
 */
class UpdatePostTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditPostTypePage()
    {
        $this->withoutExceptionHandling();
        $this->signInWithPermission('story.update');

        $response = $this->get(route('post-types.edit', $this->postType));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdatePostType()
    {
        $this->signInWithPermission('story.update');

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
    }

    /** @test **/
    public function eventIsDispatchedWhenPostTypeIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('story.update');

        $this->put(
            route('post-types.update', $this->postType),
            PostType::factory()->make()->toArray()
        );

        Event::assertDispatched(PostTypeUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditPostTypePage()
    {
        $this->signIn();

        $response = $this->get(route('post-types.edit', $this->postType));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdatePostType()
    {
        $this->signIn();

        $response = $this->putJson(
            route('post-types.update', $this->postType),
            PostType::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditPostTypePage()
    {
        $response = $this->getJson(route('post-types.edit', $this->postType));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdatePostType()
    {
        $response = $this->putJson(
            route('post-types.update', $this->postType),
            PostType::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
