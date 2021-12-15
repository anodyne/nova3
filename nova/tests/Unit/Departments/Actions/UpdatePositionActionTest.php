<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\UpdatePosition;
use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class UpdatePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()->create();
    }

    /** @test **/
    public function itUpdatesAPosition()
    {
        $newDepartment = Department::factory()->create();

        $data = new PositionData([
            'name' => 'Executive Officer',
            'description' => 'Lorem consectetur adipisicing elit.',
            'active' => false,
            'available' => 5,
            'department_id' => $newDepartment->id,
            'department' => $newDepartment,
        ]);

        $position = UpdatePosition::run($this->position, $data);

        $this->assertTrue($position->exists);
        $this->assertEquals('Executive Officer', $position->name);
        $this->assertEquals('Lorem consectetur adipisicing elit.', $position->description);
        $this->assertFalse($position->active);
        $this->assertEquals($newDepartment->id, $position->department_id);
        $this->assertEquals(5, $position->available);
    }
}
