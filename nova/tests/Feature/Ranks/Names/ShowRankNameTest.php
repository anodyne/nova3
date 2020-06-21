<?php

namespace Tests\Feature\Ranks\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class ShowRankNameTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = create(RankName::class);
    }

    /** @test **/
    public function authorizedUserCanViewARankName()
    {
        $this->signInWithPermission('rank.view');

        $response = $this->get(route('ranks.names.show', $this->name));
        $response->assertSuccessful();
        $response->assertViewHas('name', $this->name);
    }

    /** @test **/
    public function unauthorizedUserCannotViewARankName()
    {
        $this->signIn();

        $response = $this->get(route('ranks.names.show', $this->name));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewARankName()
    {
        $response = $this->getJson(route('ranks.names.show', $this->name));
        $response->assertUnauthorized();
    }
}
