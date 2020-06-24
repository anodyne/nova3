<?php

namespace Nova\Departments\Providers;

use Nova\Departments\Http\Responses\DeleteDepartmentResponse;
use Nova\DomainServiceProvider;
use Nova\Departments\Models\Department;
use Nova\Departments\Policies\DepartmentPolicy;
use Nova\Departments\Http\Responses\ShowDepartmentResponse;
use Nova\Departments\Http\Responses\ShowAllDepartmentsResponse;

class DepartmentServiceProvider extends DomainServiceProvider
{
    protected $policies = [
        Department::class => DepartmentPolicy::class,
    ];

    protected $responsables = [
        DeleteDepartmentResponse::class,
        ShowAllDepartmentsResponse::class,
        ShowDepartmentResponse::class,
    ];
}
