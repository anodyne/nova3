<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class DuplicateRankGroup
{
    use AsAction;

    public function handle(RankGroup $original, RankGroupData $data): RankGroup
    {
        return DB::transaction(function () use ($original, $data) {
            $rankGroup = $original->replicate(['ranks_count']);
            $rankGroup->fill(Arr::except($data->toArray(), 'base_image'));
            $rankGroup->save();

            $original->ranks->each(
                fn (RankItem $rank) => $rankGroup->ranks()->create([
                    ...Arr::except($rank->toArray(), ['id', 'name', 'created_at', 'updated_at']),
                    ...Arr::only($data->toArray(), 'base_image'),
                ])
            );

            activity()
                ->performedOn($original)
                ->withProperty('replica', $rankGroup->id)
                ->event('duplicated')
                ->log('duplicated');

            return $rankGroup->refresh();
        });
    }
}
