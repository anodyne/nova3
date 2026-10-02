<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Actions\Action;

class DuplicateDepartment extends Action
{
    public function handle(Department $original, DepartmentData $data): Department
    {
        return DB::transaction(function () use ($original, $data) {
            $department = $original->replicate([
                'positions_count',
                'active_characters_count',
                'active_users_count',
                'prefixed_id',
            ]);
            $department->forceFill($data->toArray());
            $department->save();

            $original->positions->each(fn (Position $position) => $department->positions()->create(
                Arr::except($position->toArray(), ['id', 'prefixed_id', 'created_at', 'updated_at'])
            ));

            activity()
                ->performedOn($original)
                ->withProperty('replica', $department->id)
                ->event('duplicated')
                ->log('duplicated');

            return $department->refresh();
        });
    }
}
