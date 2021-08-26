<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeCreated;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\CreatePostTypeRequest;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class CreatePostTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreatePostTypePage()
    {
        $this->signInWithPermission('story.create');

        $response = $this->get(route('post-types.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreatePostType()
    {
        $this->signInWithPermission('story.create');

        $postType = PostType::factory()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('post-types.store'),
            $postType->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('post_types', $postType->only('name', 'key'));

        $this->assertRouteUsesFormRequest(
            'post-types.store',
            CreatePostTypeRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenPostTypeIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('story.create');

        $this->post(
            route('post-types.store'),
            PostType::factory()->make()->toArray()
        );

        Event::assertDispatched(PostTypeCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreatePostTypePage()
    {
        $this->signIn();

        $response = $this->get(route('post-types.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreatePostType()
    {
        $this->signIn();

        $response = $this->postJson(
            route('post-types.store'),
            PostType::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreatePostTypePage()
    {
        $response = $this->getJson(route('post-types.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreatePostType()
    {
        $response = $this->postJson(
            route('post-types.store'),
            PostType::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
