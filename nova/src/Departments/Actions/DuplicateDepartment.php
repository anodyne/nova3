<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DuplicateDepartment
{
    use AsAction;

    public function handle(Department $original, DepartmentData $data): Department
    {
        return DB::transaction(function () use ($original, $data) {
            $replica = $original->replicate([
                'positions_count',
                'active_characters_count',
                'active_users_count',
                'prefixed_id',
            ]);
            $replica->forceFill($data->all());
            $replica->save();

            $original->positions->each(fn (Position $position) => $replica->positions()->create(
                Arr::except($position->toArray(), ['id', 'prefixed_id', 'created_at', 'updated_at'])
            ));

            activity()
                ->performedOn($original)
                ->withProperty('replica', $replica->id)
                ->event('duplicated')
                ->log('duplicated');

            return $replica->refresh();
        });
    }
}
