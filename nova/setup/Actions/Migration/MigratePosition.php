<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyPosition object{
 *     pos_dept: int|null,
 *     pos_name: string,
 *     pos_desc: string|null,
 *     pos_display: string,
 *     pos_open: int|bool,
 *     pos_order: int,
 *     pos_id: int
 * }
 */
class MigratePosition
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /**
     * @param  LegacyPosition  $model
     * @param  Collection<int, Upgrade>|null  $departments
     */
    public function handle(object $model, ?Collection $departments): void
    {
        $newDepartmentId = $this->getNewId(
            id: $model->pos_dept,
            collection: $departments,
            upgradeKey: 'department'
        );

        DB::transaction(function () use ($model, $newDepartmentId): void {
            $positionId = DB::table('positions')->insertGetId([
                'name' => $model->pos_name,
                'description' => $model->pos_desc,
                'status' => match ($model->pos_display) {
                    'y' => BasicStatus::Active->value,
                    default => BasicStatus::Inactive->value,
                },
                'available' => $model->pos_open,
                'order_column' => $model->pos_order,
                'department_id' => $newDepartmentId,
                'created_at' => now('UTC'),
                'updated_at' => now('UTC'),
            ]);

            Upgrade::firstOrCreate([
                'type' => 'position',
                'old_id' => $model->pos_id,
                'new_id' => $positionId,
            ]);
        });
    }

    /** @param LegacyPosition $model */
    public function asJob(object $model): void
    {
        $this->handle(
            model: $model,
            departments: null
        );
    }
}
