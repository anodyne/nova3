<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeDeleted;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

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

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeletePostType()
    {
        $this->signInWithPermission('post-type.delete');

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

        $this->signInWithPermission('post-type.delete');

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
