<?php

namespace Nova\Departments\Providers;

use Nova\Departments\Responses;
use Nova\DomainServiceProvider;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Policies\PositionPolicy;
use Nova\Departments\Policies\DepartmentPolicy;
use Nova\Departments\Livewire\PositionsDropdown;
use Nova\Departments\Livewire\PositionsCollector;
use Nova\Departments\Livewire\UploadDepartmentHeaderImage;

class DepartmentServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'departments:upload-header-image' => UploadDepartmentHeaderImage::class,
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
}
