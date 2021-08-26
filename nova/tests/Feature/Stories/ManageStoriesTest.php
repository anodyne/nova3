<?php

declare(strict_types=1);

namespace Tests\Feature\Stories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group stories
 */
class ManageStoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageStoriesPage()
    {
        $this->signInWithPermission('story.create');

        $response = $this->get(route('stories.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageStoriesPage()
    {
        $this->signInWithPermission('story.update');

        $response = $this->get(route('stories.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageStoriesPage()
    {
        $this->signInWithPermission('story.delete');

        $response = $this->get(route('stories.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageStoriesPage()
    {
        $this->signInWithPermission('story.view');

        $response = $this->get(route('stories.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageStoriesPage()
    {
        $this->signIn();

        $response = $this->get(route('stories.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageStoriesPage()
    {
        $response = $this->getJson(route('stories.index'));
        $response->assertUnauthorized();
    }
}
