<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeCreated;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\CreatePostTypeRequest;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class CreatePostTypeTest extends TestCase
{
    /** @test **/
    public function authorizedUserCanViewTheCreatePostTypePage()
    {
        $this->signInWithPermission('post-type.create');

        $response = $this->get(route('post-types.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreatePostType()
    {
        $this->withoutExceptionHandling();
        $this->signInWithPermission('post-type.create');

        $postType = PostType::factory()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('post-types.store'),
            array_merge($postType->toArray(), [
                'status' => 'active',
            ])
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

        $this->signInWithPermission('post-types.create');

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
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthorizedUserCannotCreatePostType()
    {
        $this->signIn();

        $response = $this->postJson(
            route('post-types.store'),
            PostType::factory()->make()->toArray()
        );
        $response->assertNotFound();
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
