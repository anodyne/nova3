<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class ShowRankNameTest extends TestCase
{
    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = RankName::factory()->create();
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
