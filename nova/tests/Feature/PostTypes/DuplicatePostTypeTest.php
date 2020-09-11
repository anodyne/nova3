<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Illuminate\Support\Facades\Event;
use Nova\PostTypes\Events\PostTypeDuplicated;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group post-types
 */
class DuplicatePostTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create([
            'key' => 'foo',
            'name' => 'Foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicatePostType()
    {
        $this->signInWithPermission(['story.create', 'story.update']);

        $this->followingRedirects();

        $response = $this->post(route('post-types.duplicate', $this->postType));
        $response->assertSuccessful();

        $this->assertDatabaseHas('post_types', [
            'name' => "Copy of {$this->postType->name}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPostTypeIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['story.create', 'story.update']);

        $this->post(route('post-types.duplicate', $this->postType));

        Event::assertDispatched(PostTypeDuplicated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicatePostType()
    {
        $this->signIn();

        $response = $this->post(route('post-types.duplicate', $this->postType));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicatePostType()
    {
        $response = $this->postJson(route('post-types.duplicate', $this->postType));
        $response->assertUnauthorized();
    }
}
