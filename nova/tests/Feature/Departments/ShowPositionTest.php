<?php

namespace Tests\Feature\Departments;

use Tests\TestCase;
use Nova\Departments\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 * @group positions
 */
class ShowPositionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = create(Position::class);
    }

    /** @test **/
    public function authorizedUserCanViewAPosition()
    {
        $this->signInWithPermission('department.view');

        $response = $this->get(route('positions.show', $this->position));
        $response->assertSuccessful();
        $response->assertViewHas('position', $this->position);
    }

    /** @test **/
    public function unauthorizedUserCannotViewAPosition()
    {
        $this->signIn();

        $response = $this->get(route('positions.show', $this->position));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewAPosition()
    {
        $response = $this->getJson(route('positions.show', $this->position));
        $response->assertUnauthorized();
    }
}
