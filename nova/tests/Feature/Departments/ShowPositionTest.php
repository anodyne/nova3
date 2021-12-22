<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group positions
 */
class ShowPositionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()->create();
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
