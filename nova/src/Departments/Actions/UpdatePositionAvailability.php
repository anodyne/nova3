<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Departments\Models\Position;

class UpdatePositionAvailability
{
    use AsAction;

    public function handle(CharacterPositionsData $data): void
    {
        $decrementData = match (true) {
            $data->oldStatus !== $data->newStatus &&
            $data->newStatus === Active::$name &&
            $data->canAutoManageNewType() => $data->newPositions?->pluck('id')->all(),

            $data->oldType === null &&
            $data->newType !== null &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType === $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType !== null &&
            $data->oldType !== $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType !== null &&
            $data->oldType !== $data->newType &&
            ! $data->hasPositionChanges() &&
            ! $data->canAutoManageOldType() &&
            $data->canAutoManageNewType() => $data->newPositions?->pluck('id')->all(),

            default => [],
        };

        $incrementData = match (true) {
            $data->oldStatus !== $data->newStatus &&
            $data->newStatus === Inactive::$name &&
            $data->canAutoManageNewType() => $data->newPositions?->pluck('id')->all(),

            $data->oldType === $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getOldActionableIds(),

            $data->oldType !== null &&
            $data->oldType !== $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageOldType() => $data->getOldActionableIds(),

            $data->oldType !== null &&
            $data->oldType !== $data->newType &&
            ! $data->hasPositionChanges() &&
            $data->canAutoManageOldType() &&
            ! $data->canAutoManageNewType() => $data->oldPositions?->pluck('id')->all(),

            default => [],
        };

        $this->decrement($decrementData ?? []);
        $this->increment($incrementData ?? []);
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
