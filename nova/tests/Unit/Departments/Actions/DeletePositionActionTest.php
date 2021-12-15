<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class DeletePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()->create();
    }

    /** @test **/
    public function itDeletesAPosition()
    {
        $position = DeletePosition::run($this->position);

        $this->assertFalse($position->exists);
    }
}
