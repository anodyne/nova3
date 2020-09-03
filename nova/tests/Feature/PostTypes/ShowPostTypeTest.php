<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->postType = create(PostType::class);

        $this->postType->fields = Fields::fromArray([
            'title' => true,
            'time' => true,
            'location' => true,
            'content' => true,
        ]);
        $this->postType->options = Options::fromArray([
            'notifyUsers' => true,
            'notifyDiscord' => true,
            'includeInPostCounts' => true,
            'multipleAuthors' => true,
        ]);

        $this->postType->save();
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
