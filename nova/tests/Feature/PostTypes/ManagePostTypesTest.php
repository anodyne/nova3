<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group storytelling
 * @group post-types
 */
class ManagePostTypesTest extends TestCase
{
    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('post-type.create');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('post-type.update');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('post-type.delete');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManagePostTypesPage()
    {
        $this->signInWithPermission('post-type.view');

        $response = $this->get(route('post-types.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function postTypesCanBeFilteredByName()
    {
        $this->signInWithPermission('post-type.create');

        PostType::factory()->create([
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
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManagePostTypesPage()
    {
        $response = $this->getJson(route('post-types.index'));
        $response->assertUnauthorized();
    }
}
