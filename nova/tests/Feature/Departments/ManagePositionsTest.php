<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
test('authorized user with create permission can view manage positions page', function () {
    $this->signInWithPermission('department.create');

    Position::factory()->create();

    $response = $this->get(route('positions.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('positions:list');
});
test('authorized user with update permission can view manage positions page', function () {
    $this->signInWithPermission('department.update');

    Position::factory()->create();

    $response = $this->get(route('positions.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('positions:list');
});
test('authorized user with delete permission can view manage positions page', function () {
    $this->signInWithPermission('department.delete');

    Position::factory()->create();

    $response = $this->get(route('positions.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('positions:list');
});
test('authorized user with view permission can view manage positions page', function () {
    $this->signInWithPermission('department.view');

    Position::factory()->create();

    $response = $this->get(route('positions.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('positions:list');
});
test('empty state is shown if there are no positions', function () {
    $this->signInWithPermission('department.create');

    $response = $this->get(route('positions.index'));
    $response->assertSuccessful();
    $response->assertSee('Add a position now');
});
test('positions can be filtered by name', function () {
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
});
test('positions can be filtered by status', function () {
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
        ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->status === PositionStatus::active)
        ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Commanding Officer');

    $component->call('setFilterValue', 'status', ['inactive'])
        ->assertSet('filteredPositions', fn ($data) => $data->total() === 1)
        ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->status === PositionStatus::inactive)
        ->assertSet('filteredPositions', fn ($data) => $data->items()[0]->name === 'Executive Officer');
});
test('positions can be filtered by available count', function () {
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
});
test('positions can be filtered by presence of assigned characters', function () {
    $this->markTestSkipped();
});
test('positions can be filtered by department', function () {
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
});
test('unauthorized user cannot view manage positions page', function () {
    $this->signIn();

    $response = $this->get(route('positions.index'));
    $response->assertNotFound();
});
test('unauthenticated user cannot view manage positions page', function () {
    $response = $this->getJson(route('positions.index'));
    $response->assertUnauthorized();
});
