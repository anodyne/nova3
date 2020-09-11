<?php

namespace Tests\Feature\Ranks\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class ManageRankGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageRankGroupsPage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.groups.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageRankGroupsPage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.groups.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageRankGroupsPage()
    {
        $this->signInWithPermission('rank.delete');

        $response = $this->get(route('ranks.groups.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageRankGroupsPage()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.groups.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function rankGroupsCanBeFilteredByName()
    {
        $this->signInWithPermission('rank.create');

        RankGroup::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('ranks.groups.index'));
        $response->assertSuccessful();

        $this->assertEquals(RankGroup::count(), $response['groups']->total());

        $response = $this->get(route('ranks.groups.index', 'search=command'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['groups']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageRankGroupsPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.groups.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageRankGroupsPage()
    {
        $response = $this->getJson(route('ranks.groups.index'));
        $response->assertUnauthorized();
    }
}
