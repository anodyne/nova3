<?php

declare(strict_types=1);

namespace Nova\Departments\Providers;

use Nova\Departments\Livewire\DepartmentsList;
use Nova\Departments\Livewire\PositionsList;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Spotlight\AddDepartment;
use Nova\Departments\Spotlight\AddPosition;
use Nova\Departments\Spotlight\EditDepartment;
use Nova\Departments\Spotlight\EditPosition;
use Nova\Departments\Spotlight\ViewDepartment;
use Nova\Departments\Spotlight\ViewPosition;
use Nova\Departments\Spotlight\ViewPositions;
use Nova\DomainServiceProvider;

class DepartmentServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'departments-list' => DepartmentsList::class,
            'positions-list' => PositionsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'department' => Department::class,
            'position' => Position::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'dep_' => Department::class,
            'pos_' => Position::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddDepartment::class,
            AddPosition::class,
            EditDepartment::class,
            EditPosition::class,
            ViewDepartment::class,
            ViewPosition::class,
            ViewPositions::class,
        ];
    }
}
