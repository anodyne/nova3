<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Requests\CreatePostTypeRequest;

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

        $postType = make(PostType::class);

        $this->followingRedirects();

        $response = $this->post(route('post-types.store'), array_merge(
            $postType->toArray(),
            [
                'fields' => [
                    'title' => true,
                    'time' => false,
                    'location' => true,
                    'content' => false,
                ],
                'options' => [
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => true,
                ],
            ]
        ));
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
            array_merge(make(PostType::class)->toArray(), [
                'fields' => [
                    'title' => true,
                    'time' => false,
                    'location' => true,
                    'content' => false,
                ],
                'options' => [
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => true,
                ],
            ])
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
            array_merge(make(PostType::class)->toArray(), [
                'fields' => [
                    'title' => true,
                    'time' => false,
                    'location' => true,
                    'content' => false,
                ],
                'options' => [
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => true,
                ],
            ])
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
            array_merge(make(PostType::class)->toArray(), [
                'fields' => [
                    'title' => true,
                    'time' => false,
                    'location' => true,
                    'content' => false,
                ],
                'options' => [
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => true,
                ],
            ])
        );
        $response->assertUnauthorized();
    }
}
