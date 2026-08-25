<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyDepartment object{
 *     dept_name: string,
 *     dept_desc: string|null,
 *     dept_display: string,
 *     dept_order: int,
 *     dept_id: int
 * }
 */
class MigrateDepartment
{
    use AsAction;
    use HandlesDates;

    /** @param LegacyDepartment $model */
    public function handle(object $model): void
    {
        DB::transaction(function () use ($model): void {
            $departmentId = DB::table('departments')->insertGetId([
                'name' => $model->dept_name,
                'description' => $model->dept_desc,
                'status' => match ($model->dept_display) {
                    'y' => BasicStatus::Active->value,
                    default => BasicStatus::Inactive->value,
                },
                'order_column' => $model->dept_order,
                'created_at' => now('UTC'),
                'updated_at' => now('UTC'),
            ]);

            Upgrade::firstOrCreate([
                'type' => 'department',
                'old_id' => $model->dept_id,
                'new_id' => $departmentId,
            ]);
        });
    }

    /** @param LegacyDepartment $model */
    public function asJob(object $model): void
    {
        $this->handle($model);
    }
}
