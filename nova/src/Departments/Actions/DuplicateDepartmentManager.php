<?php

namespace Nova\Departments\Actions;

use Illuminate\Http\Request;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Models\Department;

class DuplicateDepartmentManager
{
    protected $duplicateDepartment;

    protected $duplicateDepartmentPositions;

    public function __construct(
        DuplicateDepartment $duplicateDepartment,
        DuplicateDepartmentPositions $duplicateDepartmentPositions
    ) {
        $this->duplicateDepartment = $duplicateDepartment;
        $this->duplicateDepartmentPositions = $duplicateDepartmentPositions;
    }

    public function execute(Department $original, Request $request): Department
    {
        $department = $this->duplicateDepartment->execute(
            $original,
            DepartmentData::fromRequest($request)
        );

        $this->duplicateDepartmentPositions->execute(
            $department,
            $original
        );

        return $department->refresh();
    }
}
