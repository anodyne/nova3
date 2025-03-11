<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;

class DuplicatePosition
{
    use AsAction;

    public function handle(Position $original, PositionData $data): Position
    {
        return DB::transaction(function () use ($original, $data) {
            $replica = $original->replicate([
                'active_characters_count',
                'active_users_count',
                'prefixed_id',
            ]);
            $replica->forceFill(collect($data->toArray())->filter()->toArray());
            $replica->save();

            activity()
                ->performedOn($original)
                ->withProperty('replica', $replica->id)
                ->event('duplicated')
                ->log('duplicated');

            return $replica->refresh();
        });
    }
}
