<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DuplicateDepartment
{
    use AsAction;

    public function handle(Department $original, DepartmentData $data): Department
    {
        $replica = $original->replicate([
            'positions_count',
            'active_characters_count',
            'active_users_count',
        ]);
        $replica->forceFill($data->all());
        $replica->save();

        $original->positions->each(fn (Position $position) => $replica->positions()->create(
            Arr::except($position->toArray(), ['id', 'created_at', 'updated_at'])
        ));

        return $replica->refresh();
    }
}
