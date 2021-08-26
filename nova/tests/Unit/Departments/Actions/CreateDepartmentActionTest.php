<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\CreateDepartment;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;
use Tests\TestCase;

/**
 * @group departments
 */
class CreateDepartmentActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateDepartment::class);
    }

    /** @test **/
    public function itCreatesADepartment()
    {
        $data = new DepartmentData([
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ]);

        $department = $this->action->execute($data);

        $this->assertTrue($department->exists);
        $this->assertEquals('Command', $department->name);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit.', $department->description);
    }

    /** @test **/
    public function itSetsTheCorrectSortOrderForANewlyCreatedDepartment()
    {
        Department::factory()->create(['sort' => 0]);
        Department::factory()->create(['sort' => 1]);

        $data = new DepartmentData([
            'name' => 'Command',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ]);

        $department = $this->action->execute($data);

        $this->assertEquals(2, $department->sort);
    }
}
