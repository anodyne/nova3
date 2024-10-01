<?php

declare(strict_types=1);

use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Models\Department;
use Nova\Forms\Livewire\FormsList;
use Nova\Forms\Models\Form;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms');

beforeEach(function () {
    $this->forms = Form::factory()->count(5)->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form.create');
    });

    test('can view the list forms page', function () {
        get(route('admin.forms.index'))->assertSuccessful();

        livewire(FormsList::class)
            ->assertCanSeeTableRecords($this->forms);
    });

    // test('can filter departments by status', function () {
    //     livewire(DepartmentsList::class)
    //         ->filterTable('status', DepartmentStatus::active->value)
    //         ->assertCanSeeTableRecords($this->departments->where('status', DepartmentStatus::active))
    //         ->assertCanNotSeeTableRecords($this->departments->where('status', '!=', DepartmentStatus::active))
    //         ->resetTableFilters()
    //         ->filterTable('status', DepartmentStatus::inactive->value)
    //         ->assertCanSeeTableRecords($this->departments->where('status', DepartmentStatus::inactive))
    //         ->assertCanNotSeeTableRecords($this->departments->where('status', '!=', DepartmentStatus::inactive));
    // });

    // test('can filter departments by the presence of positions', function () {
    //     Department::factory()->create();

    //     livewire(DepartmentsList::class)
    //         ->filterTable('has_positions', true)
    //         ->assertCountTableRecords(5)
    //         ->resetTableFilters()
    //         ->filterTable('has_positions', false)
    //         ->assertCountTableRecords(1);
    // });

    test('can search forms by name', function () {
        Form::factory()->create(['name' => 'A test form']);

        livewire(FormsList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->searchTable('test form')
            ->assertCountTableRecords(1);
    });
});

describe('authorized user with form create permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'form.create');
    });

    test('has the correct permissions', function () {
        livewire(FormsList::class)
            ->assertTableActionHidden(EditAction::class, $this->forms->first())
            ->assertTableActionHidden(DeleteAction::class, $this->forms->first());
    });
});

describe('authorized user with form delete permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'form.delete');
    });

    test('has the correct permissions', function () {
        livewire(FormsList::class)
            ->assertTableActionHidden(EditAction::class, $this->forms->first())
            ->assertTableActionVisible(DeleteAction::class, $this->forms->first());
    });
});

describe('authorized user with form update permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'form.update');
    });

    test('has the correct permissions', function () {
        livewire(FormsList::class)
            ->assertTableActionVisible(EditAction::class, $this->forms->first())
            ->assertTableActionHidden(DeleteAction::class, $this->forms->first());
    });
});

describe('authorized user with form view permissions', function () {
    beforeEach(function () {
        signIn(permissions: 'form.view');
    });

    test('has the correct permissions', function () {
        livewire(FormsList::class)
            ->assertTableActionHidden(EditAction::class, $this->forms->first())
            ->assertTableActionHidden(DeleteAction::class, $this->forms->first());
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the manage forms page', function () {
        get(route('admin.forms.index'))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage forms page', function () {
        get(route('admin.forms.index'))
            ->assertRedirectToRoute('login');
    });
});
