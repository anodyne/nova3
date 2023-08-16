<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Departments\Models\Position;

class UpdatePositionAvailability
{
    use AsAction;

    public function handle(CharacterPositionsData $data): void
    {
        $decrementData = match (true) {
            $data->previousType === null &&
            $data->currentType !== null &&
            $data->canAutoManageCurrentType() => $data->getCurrentActionableIds(),

            $data->previousType === $data->currentType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageCurrentType() => $data->getCurrentActionableIds(),

            $data->previousType !== null &&
            $data->previousType !== $data->currentType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageCurrentType() => $data->getCurrentActionableIds(),

            $data->previousType !== null &&
            $data->previousType !== $data->currentType &&
            ! $data->hasPositionChanges() &&
            ! $data->canAutoManagePreviousType() &&
            $data->canAutoManageCurrentType() => $data->currentPositions->pluck('id')->all(),

            default => [],
        };

        $incrementData = match (true) {
            $data->previousType === $data->currentType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageCurrentType() => $data->getPreviousActionableIds(),

            $data->previousType !== null &&
            $data->previousType !== $data->currentType &&
            $data->hasPositionChanges() &&
            $data->canAutoManagePreviousType() => $data->getPreviousActionableIds(),

            $data->previousType !== null &&
            $data->previousType !== $data->currentType &&
            ! $data->hasPositionChanges() &&
            $data->canAutoManagePreviousType() &&
            ! $data->canAutoManageCurrentType() => $data->previousPositions->pluck('id')->all(),

            default => [],
        };

        $this->decrement($decrementData);
        $this->increment($incrementData);
    }

    protected function decrement(array $ids): void
    {
        Position::query()
            ->whereIn('id', $ids)
            ->where('available', '>', 0)
            ->decrement('available');
    }

    protected function increment(?array $ids): void
    {
        Position::query()
            ->whereIn('id', $ids)
            ->increment('available');
    }
}
