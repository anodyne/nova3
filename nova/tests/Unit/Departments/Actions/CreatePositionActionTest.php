<?php

namespace Tests\Unit\Departments\Actions;

use Tests\TestCase;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\CreatePosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\DataTransferObjects\PositionData;

/**
 * @group departments
 * @group positions
 */
class CreatePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreatePosition::class);

        $this->department = create(Department::class);
    }

    /** @test **/
    public function itCreatesAPosition()
    {
        $data = new PositionData;
        $data->name = 'Captain';
        $data->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $data->available = 1;
        $data->department = $this->department;
        $data->department_id = $this->department->id;

        $position = $this->action->execute($data);

        $this->assertTrue($position->exists);
        $this->assertEquals('Captain', $position->name);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit.', $position->description);
        $this->assertEquals(1, $position->available);
        $this->assertEquals($this->department->id, $position->department_id);
    }

    /** @test **/
    public function itSetsTheCorrectSortOrderForANewlyCreatedPosition()
    {
        create(Position::class, [
            'department_id' => $this->department,
            'sort' => 0,
        ]);
        create(Position::class, [
            'department_id' => $this->department,
            'sort' => 1,
        ]);

        $data = new PositionData;
        $data->name = 'Captain';
        $data->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $data->available = 1;
        $data->department = $this->department;
        $data->department_id = $this->department->id;

        $position = $this->action->execute($data);

        $this->assertEquals(2, $position->sort);
    }
}
