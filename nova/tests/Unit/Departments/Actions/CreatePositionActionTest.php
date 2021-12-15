<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\CreatePosition;
use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class CreatePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->department = Department::factory()->create();
    }

    /** @test **/
    public function itCreatesAPosition()
    {
        $data = new PositionData([
            'name' => 'Captain',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'available' => 1,
            'department' => $this->department,
            'department_id' => $this->department->id,
        ]);

        $position = CreatePosition::run($data);

        $this->assertTrue($position->exists);
        $this->assertEquals('Captain', $position->name);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit.', $position->description);
        $this->assertEquals(1, $position->available);
        $this->assertEquals($this->department->id, $position->department_id);
    }

    /** @test **/
    public function itSetsTheCorrectSortOrderForANewlyCreatedPosition()
    {
        Position::factory()->create([
            'department_id' => $this->department,
            'sort' => 0,
        ]);
        Position::factory()->create([
            'department_id' => $this->department,
            'sort' => 1,
        ]);

        $data = new PositionData([
            'name' => 'Captain',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'available' => 1,
            'department' => $this->department,
            'department_id' => $this->department->id,
        ]);

        $position = CreatePosition::run($data);

        $this->assertEquals(2, $position->sort);
    }
}
