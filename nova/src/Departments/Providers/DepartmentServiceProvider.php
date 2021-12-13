<?php

declare(strict_types=1);

namespace Nova\Departments\Providers;

use Nova\Departments\Livewire\PositionsCollector;
use Nova\Departments\Livewire\PositionsDropdown;
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
            'positions:collector' => PositionsCollector::class,
            'positions:dropdown' => PositionsDropdown::class,
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
