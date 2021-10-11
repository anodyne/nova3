<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class ShowPostTypeTest extends TestCase
{
    use RefreshDatabase;

    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewAPostType()
    {
        $this->signInWithPermission('story.view');

        $response = $this->get(route('post-types.show', $this->postType));
        $response->assertSuccessful();
        $response->assertViewHas('postType', $this->postType);
    }

    /** @test **/
    public function unauthorizedUserCannotViewAPostType()
    {
        $this->signIn();

        $response = $this->get(route('post-types.show', $this->postType));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewAPostType()
    {
        $response = $this->getJson(route('post-types.show', $this->postType));
        $response->assertUnauthorized();
    }
}
