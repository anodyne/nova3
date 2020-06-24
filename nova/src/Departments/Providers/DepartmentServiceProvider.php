<?php

namespace Nova\Departments\Providers;

use Nova\DomainServiceProvider;
use Nova\Departments\Models\Department;
use Nova\Departments\Policies\DepartmentPolicy;
use Nova\Departments\Http\Responses\ShowDepartmentResponse;
use Nova\Departments\Http\Responses\CreateDepartmentResponse;
use Nova\Departments\Http\Responses\DeleteDepartmentResponse;
use Nova\Departments\Http\Responses\UpdateDepartmentResponse;
use Nova\Departments\Http\Responses\ShowAllDepartmentsResponse;

class DepartmentServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Department::class => DepartmentPolicy::class,
    ];

    protected $responsables = [
        CreateDepartmentResponse::class,
        DeleteDepartmentResponse::class,
        ShowAllDepartmentsResponse::class,
        ShowDepartmentResponse::class,
        UpdateDepartmentResponse::class,
    ];
}
