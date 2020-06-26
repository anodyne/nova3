<?php

namespace Tests\Unit\Departments\Actions;

use Tests\TestCase;
use Nova\Departments\Models\Position;
use Nova\Departments\Actions\DeletePosition;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group departments
 * @group positions
 */
class DeletePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeletePosition::class);

        $this->position = create(Position::class);
    }

    /** @test **/
    public function itDeletesAPosition()
    {
        $position = $this->action->execute($this->position);

        $this->assertFalse($position->exists);
    }
}
