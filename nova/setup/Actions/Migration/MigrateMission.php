<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

class MigrateMission
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    public function handle(object $model, ?Collection $missionGroups): void
    {
        $newParentStoryId = $this->getNewId(
            id: $model->mission_group,
            collection: $missionGroups,
            upgradeKey: 'mission-group'
        );

        DB::transaction(function () use ($model, $newParentStoryId): void {
            $storyId = DB::table('stories')->insertGetId([
                'title' => $model->mission_title,
                'description' => $model->mission_desc,
                'order_column' => $model->mission_order,
                'parent_id' => $newParentStoryId,
                'status' => $model->mission_status,
                'started_at' => $this->convertDate($model->mission_start),
                'ended_at' => $this->convertDate($model->mission_end),
                'summary' => $model->mission_summary,
                'created_at' => now('UTC'),
                'updated_at' => now('UTC'),
            ]);

            // TODO: figure out how to handle images

            Upgrade::firstOrCreate([
                'type' => 'mission',
                'old_id' => $model->mission_id,
                'new_id' => $storyId,
            ]);
        });
    }

    public function asJob(object $model): void
    {
        $this->handle(
            model: $model,
            missionGroups: null
        );
    }
}
