<?php

namespace Tests\Feature\PostTypes;

use Tests\TestCase;
use Nova\PostTypes\Models\PostType;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group stories
 * @group post-types
 */
class ManagePostTypesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('story.create');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('story.update');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('story.delete');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('story.view');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function postTypesCanBeFilteredByName()
    {
        $this->signInWithPermission('story.create');

        create(PostType::class, [
            'name' => 'barbaz',
        ]);

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();

        $this->assertEquals(PostType::count(), $response['postTypes']->total());

        $response = $this->get(route('post-types.index', 'search=barbaz'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['postTypes']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManagePostTypesPage()
    {
        $this->signIn();

        $response = $this->get(route('post-types.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManagePostTypesPage()
    {
        $response = $this->getJson(route('post-types.index'));
        $response->assertUnauthorized();
    }
}
