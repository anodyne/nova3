<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Active;
use Nova\Departments\Models\States\Departments\Inactive;
use Tests\TestCase;

/**
 * @group departments
 */
class ManageDepartmentsTest extends TestCase
{
    /** @test */
    public function emptyStateIsShownIfThereAreNoDepartments()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
        $response->assertSee('Add a deparment now');
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.create');

        Department::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('departments:list');
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.update');

        Department::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('departments:list');
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.delete');

        Department::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('departments:list');
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageDepartmentsPage()
    {
        $this->signInWithPermission('department.view');

        Department::factory()->create([
            'name' => 'Command',
        ]);

        $response = $this->get(route('departments.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('departments:list');
    }

    /** @test **/
    public function departmentsCanBeFilteredByName()
    {
        $this->signInWithPermission('department.create');

        Department::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Command'],
                ['name' => 'Operations'],
                ['name' => 'Science'],
            ))
            ->create();

        $component = Livewire::test(DepartmentsList::class);

        $component->assertSet('filteredDepartments', fn ($data) => $data->total() === 3);

        $component->set('search', 'command')
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->name === 'Command');
    }

    /** @test **/
    public function departmentsCanBeFilteredByStatus()
    {
        $this->signInWithPermission('department.create');

        Department::factory()
            ->count(2)
            ->state(new Sequence(
                ['status' => 'active'],
                ['status' => 'inactive'],
            ))
            ->create();

        $component = Livewire::test(DepartmentsList::class);

        $component->assertSet('filteredDepartments', fn ($data) => $data->total() === 2);

        $component->call('setFilterValue', 'status', ['active'])
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->status->equals(Active::class));

        $component->call('setFilterValue', 'status', ['inactive'])
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->status->equals(Inactive::class));
    }

    /** @test **/
    public function departmentsCanBeFilteredByPositionCount()
    {
        $this->signInWithPermission('department.create');

        Department::factory()->create(['name' => 'Command']);
        Department::factory()->hasPositions(1)->create(['name' => 'Operations']);
        Department::factory()->hasPositions(2)->create(['name' => 'Science']);

        $component = Livewire::test(DepartmentsList::class);

        $component->assertSet('filteredDepartments', fn ($data) => $data->total() === 3);

        $component->call('setFilterValue', 'position_count', 'none')
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->name === 'Command');

        $component->call('setFilterValue', 'position_count', 'one')
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->name === 'Operations');

        $component->call('setFilterValue', 'position_count', 'multiple')
            ->assertSet('filteredDepartments', fn ($data) => $data->total() === 1)
            ->assertSet('filteredDepartments', fn ($data) => $data->items()[0]->name === 'Science');
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageDepartmentsPage()
    {
        $this->signIn();

        $response = $this->get(route('departments.index'));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageDepartmentsPage()
    {
        $response = $this->getJson(route('departments.index'));
        $response->assertUnauthorized();
    }
}
