<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class ManageRankNamesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageRankNamesPage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.names.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageRankNamesPage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.names.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageRankNamesPage()
    {
        $this->signInWithPermission('rank.delete');

        $response = $this->get(route('ranks.names.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageRankNamesPage()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.names.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function rankNamesCanBeFilteredByName()
    {
        $this->signInWithPermission('rank.create');

        RankName::factory()->create([
            'name' => 'Captain',
        ]);

        $response = $this->get(route('ranks.names.index'));
        $response->assertSuccessful();

        $this->assertEquals(RankName::count(), $response['names']->total());

        $response = $this->get(route('ranks.names.index', 'search=captain'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['names']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageRankNamesPage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.names.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageRankNamesPage()
    {
        $response = $this->getJson(route('ranks.names.index'));
        $response->assertUnauthorized();
    }
}
