<?php

declare(strict_types=1);

namespace Tests\Feature\Departments;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\States\Positions\Active;
use Nova\Departments\Models\States\Positions\Inactive;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class ManagePositionsTest extends TestCase
{
    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.create');

        Position::factory()->create();

        $response = $this->get(route('positions.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('positions:list');
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.update');

        Position::factory()->create();

        $response = $this->get(route('positions.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('positions:list');
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.delete');

        Position::factory()->create();

        $response = $this->get(route('positions.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('positions:list');
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManagePositionsPage()
    {
        $this->signInWithPermission('department.view');

        Position::factory()->create();

        $response = $this->get(route('positions.index'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('positions:list');
    }

    /** @test */
    public function emptyStateIsShownIfThereAreNoPositions()
    {
        $this->signInWithPermission('department.create');

        $response = $this->get(route('positions.index'));
        $response->assertSuccessful();
        $response->assertSee('Add a position now');
    }

    /** @test **/
    public function positionsCanBeFilteredByName()
    {
        $this->signInWithPermission('department.create');

        Position::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Commanding Officer'],
                ['name' => 'Executive Officer'],
                ['name' => 'Second Officer'],
            ))
            ->create();

        $component = Livewire::test(PositionsList::class);

        $component->assertSet('filteredPositions', fn ($data) => $data->total() === 3);

        $component->set('search', 'commanding')
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Commanding Officer');
    }

    /** @test **/
    public function positionsCanBeFilteredByStatus()
    {
        $this->signInWithPermission('department.create');

        Position::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Commanding Officer', 'status' => 'active'],
                ['name' => 'Executive Officer', 'status' => 'inactive'],
            ))
            ->create();

        $component = Livewire::test(PositionsList::class);

        $component->assertSet('filteredPositions', fn ($data) => $data->total() === 2);

        $component->call('setFilterValue', 'status', ['active'])
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->status->equals(Active::class))
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Commanding Officer');

        $component->call('setFilterValue', 'status', ['inactive'])
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->status->equals(Inactive::class))
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Executive Officer');
    }

    /** @test */
    public function positionsCanBeFilteredByAvailableCount()
    {
        $this->signInWithPermission('department.create');

        Position::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Commanding Officer', 'available' => 0],
                ['name' => 'Executive Officer', 'available' => 1],
                ['name' => 'Second Officer', 'available' => 2],
            ))
            ->create();

        $component = Livewire::test(PositionsList::class);

        $component->assertSet('filteredPositions', fn ($data) => $data->total() === 3);

        $component->call('setFilterValue', 'available_count', 'none')
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Commanding Officer');

        $component->call('setFilterValue', 'available_count', 'one')
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Executive Officer');

        $component->call('setFilterValue', 'available_count', 'multiple')
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Second Officer');
    }

    /** @test */
    public function positionsCanBeFilteredByPresenceOfAssignedCharacters()
    {
        $this->markTestSkipped();
    }

    /** @test */
    public function positionsCanBeFilteredByDepartment()
    {
        $this->signInWithPermission('department.create');

        Department::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Command'],
                ['name' => 'Operations'],
            ))
            ->create();

        Position::factory()
            ->count(4)
            ->state(new Sequence(
                fn ($sequence) => ['name' => 'Commanding Officer', 'department_id' => 1],
                fn ($sequence) => ['name' => 'Executive Officer', 'department_id' => 1],
                fn ($sequence) => ['name' => 'Chief Ops Officer', 'department_id' => 2],
                fn ($sequence) => ['name' => 'Ops Officer', 'department_id' => 2],
            ))
            ->create();

        $component = Livewire::test(PositionsList::class);

        $component->assertSet('filteredPositions', fn ($data) => $data->total() === 4);

        $component->call('setFilterValue', 'department', Department::find(1)->id)
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 2)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Commanding Officer')
            ->assertSet('filteredPositions', fn ($data) => $data->items()[1]->name === 'Executive Officer');

        $component->call('setFilterValue', 'department', Department::find(2)->id)
            ->assertSet('filteredPositions', fn ($data) => $data->total() === 2)
            ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Chief Ops Officer')
            ->assertSet('filteredPositions', fn ($data) => $data->items()[1]->name === 'Ops Officer');
    }

    /** @test **/
    public function unauthorizedUserCannotViewManagePositionsPage()
    {
        $this->signIn();

        $response = $this->get(route('positions.index'));
        $response->assertNotFound();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManagePositionsPage()
    {
        $response = $this->getJson(route('positions.index'));
        $response->assertUnauthorized();
    }
}
