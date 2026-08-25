<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyMissionGroup object{
 *     misgroup_parent: int|null,
 *     misgroup_name: string,
 *     misgroup_desc: string|null,
 *     misgroup_order: int,
 *     misgroup_id: int
 * }
 */
class MigrateMissionGroup
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /** @param LegacyMissionGroup $model */
    public function handle(object $model): void
    {
        $newParentId = $this->getNewId(
            id: $model->misgroup_parent,
            collection: null,
            upgradeKey: 'mission-group'
        );

        DB::transaction(function () use ($model, $newParentId): void {
            $storyId = DB::table('stories')->insertGetId([
                'title' => $model->misgroup_name,
                'description' => $model->misgroup_desc,
                'order_column' => $model->misgroup_order,
                'status' => 'completed',
                'parent_id' => $newParentId,
            ]);

            Upgrade::firstOrCreate([
                'type' => 'mission-group',
                'old_id' => $model->misgroup_id,
                'new_id' => $storyId,
            ]);
        });
    }

    /** @param LegacyMissionGroup $model */
    public function asJob(object $model): void
    {
        $this->handle($model);
    }
}
