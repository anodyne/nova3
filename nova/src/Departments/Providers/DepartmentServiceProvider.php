<?php

namespace Nova\Departments\Providers;

use Nova\Departments\Http\Livewire\PositionsDropdown;
use Nova\DomainServiceProvider;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Policies\PositionPolicy;
use Nova\Departments\Policies\DepartmentPolicy;
use Nova\Departments\Http\Responses\ShowPositionResponse;
use Nova\Departments\Http\Responses\CreatePositionResponse;
use Nova\Departments\Http\Responses\DeletePositionResponse;
use Nova\Departments\Http\Responses\ShowDepartmentResponse;
use Nova\Departments\Http\Responses\UpdatePositionResponse;
use Nova\Departments\Http\Responses\CreateDepartmentResponse;
use Nova\Departments\Http\Responses\DeleteDepartmentResponse;
use Nova\Departments\Http\Responses\ShowAllPositionsResponse;
use Nova\Departments\Http\Responses\UpdateDepartmentResponse;
use Nova\Departments\Http\Responses\ShowAllDepartmentsResponse;

class DepartmentServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'positions:dropdown' => PositionsDropdown::class,
    ];

    protected $policies = [
        Department::class => DepartmentPolicy::class,
        Position::class => PositionPolicy::class,
    ];

    protected $responsables = [
        CreateDepartmentResponse::class,
        DeleteDepartmentResponse::class,
        ShowAllDepartmentsResponse::class,
        ShowDepartmentResponse::class,
        UpdateDepartmentResponse::class,

        CreatePositionResponse::class,
        DeletePositionResponse::class,
        ShowAllPositionsResponse::class,
        ShowPositionResponse::class,
        UpdatePositionResponse::class,
    ];
}
