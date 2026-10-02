<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Actions\Action;

class DeleteDepartment extends Action
{
    public function handle(Department $department): Department
    {
        return DB::transaction(function () use ($department) {
            $department->positions->each(
                fn (Position $position): mixed => DeletePosition::run($position)
            );

            return tap($department)->delete();
        });
    }
}
