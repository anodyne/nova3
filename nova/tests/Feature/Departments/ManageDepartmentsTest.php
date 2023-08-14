<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Departments\Active;
use Nova\Departments\Models\States\Departments\Inactive;
test('empty state is shown if there are no departments', function () {
    $this->signInWithPermission('department.create');

    $response = $this->get(route('departments.index'));
    $response->assertSuccessful();
    $response->assertSee('Add a deparment now');
});
test('authorized user with create permission can view manage departments page', function () {
    $this->signInWithPermission('department.create');

    Department::factory()->create([
        'name' => 'Command',
    ]);

    $response = $this->get(route('departments.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('departments:list');
});
test('authorized user with update permission can view manage departments page', function () {
    $this->signInWithPermission('department.update');

    Department::factory()->create([
        'name' => 'Command',
    ]);

    $response = $this->get(route('departments.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('departments:list');
});
test('authorized user with delete permission can view manage departments page', function () {
    $this->signInWithPermission('department.delete');

    Department::factory()->create([
        'name' => 'Command',
    ]);

    $response = $this->get(route('departments.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('departments:list');
});
test('authorized user with view permission can view manage departments page', function () {
    $this->signInWithPermission('department.view');

    Department::factory()->create([
        'name' => 'Command',
    ]);

    $response = $this->get(route('departments.index'));
    $response->assertSuccessful();
    $response->assertSeeLivewire('departments:list');
});
test('departments can be filtered by name', function () {
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
});
test('departments can be filtered by status', function () {
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
});
test('departments can be filtered by position count', function () {
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
});
test('unauthorized user cannot view manage departments page', function () {
    $this->signIn();

    $response = $this->get(route('departments.index'));
    $response->assertNotFound();
});
test('unauthenticated user cannot view manage departments page', function () {
    $response = $this->getJson(route('departments.index'));
    $response->assertUnauthorized();
});
