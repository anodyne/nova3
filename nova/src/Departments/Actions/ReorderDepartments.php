<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Department;

class ReorderDepartments
{
    use AsAction;

    public function handle(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($id, $index) {
            Department::where('id', $id)->update(['sort' => $index]);
        });
    }
}
