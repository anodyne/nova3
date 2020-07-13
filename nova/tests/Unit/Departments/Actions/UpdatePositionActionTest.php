<?php

namespace Tests\Unit\Departments\Actions;

use Tests\TestCase;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\UpdatePosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\DataTransferObjects\PositionData;

/**
 * @group departments
 * @group positions
 */
class UpdatePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdatePosition::class);

        $this->position = create(Position::class);
    }

    /** @test **/
    public function itUpdatesAPosition()
    {
        $newDepartment = create(Department::class);

        $data = new PositionData([
            'name' => 'Executive Officer',
            'description' => 'Lorem consectetur adipisicing elit.',
            'active' => false,
            'available' => 5,
            'department_id' => $newDepartment->id,
            'department' => $newDepartment,
        ]);

        $position = $this->action->execute($this->position, $data);

        $this->assertTrue($position->exists);
        $this->assertEquals('Executive Officer', $position->name);
        $this->assertEquals('Lorem consectetur adipisicing elit.', $position->description);
        $this->assertFalse($position->active);
        $this->assertEquals($newDepartment->id, $position->department_id);
        $this->assertEquals(5, $position->available);
    }
}
