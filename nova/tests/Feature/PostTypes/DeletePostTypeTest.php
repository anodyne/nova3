<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group post-types
 */
class DeletePostTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = create(PostType::class);
    }

    /** @test **/
    public function authorizedUserCanDeletePostType()
    {
        $this->signInWithPermission('story.delete');

        $this->followingRedirects();

        $response = $this->delete(route('post-types.destroy', $this->postType));
        $response->assertSuccessful();

        $this->assertSoftDeleted('post_types', [
            'id' => $this->postType->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPostTypeIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('story.delete');

        $this->delete(route('post-types.destroy', $this->postType));

        Event::assertDispatched(PostTypeDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeletePostType()
    {
        $this->signIn();

        $response = $this->delete(route('post-types.destroy', $this->postType));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeletePostType()
    {
        $response = $this->deleteJson(route('post-types.destroy', $this->postType));
        $response->assertUnauthorized();
    }
}
