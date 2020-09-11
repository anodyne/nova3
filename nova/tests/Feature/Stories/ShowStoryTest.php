<?php

namespace Tests\Feature\Stories;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 */
class ShowStoryTest extends TestCase
{
    use RefreshDatabase;

    protected $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewAStory()
    {
        $this->signInWithPermission('story.view');

        $response = $this->get(route('stories.show', $this->story));
        $response->assertSuccessful();
        $response->assertViewHas('story', $this->story);
    }

    /** @test **/
    public function unauthorizedUserCannotViewAStory()
    {
        $this->signIn();

        $response = $this->get(route('stories.show', $this->story));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewAStory()
    {
        $response = $this->getJson(route('stories.show', $this->story));
        $response->assertUnauthorized();
    }
}
