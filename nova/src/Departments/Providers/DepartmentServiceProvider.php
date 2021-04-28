<?php

namespace Nova\Departments\Providers;

use Nova\Departments\Responses;
use Nova\DomainServiceProvider;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Spotlight\EditPosition;
use Nova\Departments\Spotlight\ViewPosition;
use Nova\Departments\Policies\PositionPolicy;
use Nova\Departments\Spotlight\ViewPositions;
use Nova\Departments\Spotlight\CreatePosition;
use Nova\Departments\Spotlight\EditDepartment;
use Nova\Departments\Spotlight\ViewDepartment;
use Nova\Departments\Policies\DepartmentPolicy;
use Nova\Departments\Livewire\PositionsDropdown;
use Nova\Departments\Spotlight\CreateDepartment;
use Nova\Departments\Livewire\PositionsCollector;

class DepartmentServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'positions:collector' => PositionsCollector::class,
        'positions:dropdown' => PositionsDropdown::class,
    ];

    protected $policies = [
        Department::class => DepartmentPolicy::class,
        Position::class => PositionPolicy::class,
    ];

    protected $responsables = [
        Responses\CreateDepartmentResponse::class,
        Responses\DeleteDepartmentResponse::class,
        Responses\ShowAllDepartmentsResponse::class,
        Responses\ShowDepartmentResponse::class,
        Responses\UpdateDepartmentResponse::class,

        Responses\CreatePositionResponse::class,
        Responses\DeletePositionResponse::class,
        Responses\ShowAllPositionsResponse::class,
        Responses\ShowPositionResponse::class,
        Responses\UpdatePositionResponse::class,
    ];

    public function spotlightCommands(): array
    {
        return [
            CreateDepartment::class,
            CreatePosition::class,
            EditDepartment::class,
            EditPosition::class,
            ViewDepartment::class,
            ViewPosition::class,
            ViewPositions::class,
        ];
    }
}
