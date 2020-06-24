<?php

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\CreateDepartment;
use Nova\Departments\DataTransferObjects\DepartmentData;
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
        $data = new DepartmentData;
        $data->name = 'Command';
        $data->description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';

        $department = $this->action->execute($data);

        $this->assertTrue($department->exists);
        $this->assertEquals('Command', $department->name);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit.', $department->description);
    }
}
