<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DuplicateDepartment
{
    use AsAction;

    public function handle(Department $original, DepartmentData $data): Department
    {
        $replica = $original->replicate();
        $replica->forceFill($data->all());
        $replica->save();

        $original->positions->each(
            fn (Position $position) => $replica->positions()->create($position->toArray())
        );

        return $replica->refresh();
    }
}
