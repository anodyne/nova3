<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class ShowPostTypeTest extends TestCase
{
    protected $postType;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType = PostType::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewAPostType()
    {
        $this->signInWithPermission('post-type.view');

        $response = $this->get(route('post-types.show', $this->postType));
        $response->assertSuccessful();
        $response->assertViewHas('postType', $this->postType);
    }

    /** @test **/
    public function unauthorizedUserCannotViewAPostType()
    {
        $this->signIn();

        $response = $this->get(route('post-types.show', $this->postType));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewAPostType()
    {
        $response = $this->getJson(route('post-types.show', $this->postType));
        $response->assertUnauthorized();
    }
}
