<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Enums\CharacterType;
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
            $data->canAutoManageNewType() => $data->newPositions?->map(fn (Position $position): int => $position->id)->values()->all(),

            ! $data->oldType instanceof CharacterType &&
            $data->newType instanceof CharacterType &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType === $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType instanceof CharacterType &&
            $data->oldType !== $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getNewActionableIds(),

            $data->oldType instanceof CharacterType &&
            $data->oldType !== $data->newType &&
            ! $data->hasPositionChanges() &&
            ! $data->canAutoManageOldType() &&
            $data->canAutoManageNewType() => $data->newPositions?->map(fn (Position $position): int => $position->id)->values()->all(),

            default => [],
        };

        $incrementData = match (true) {
            $data->oldStatus !== $data->newStatus &&
            $data->newStatus === Inactive::$name &&
            $data->canAutoManageNewType() => $data->newPositions?->map(fn (Position $position): int => $position->id)->values()->all(),

            $data->oldType === $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageNewType() => $data->getOldActionableIds(),

            $data->oldType instanceof CharacterType &&
            $data->oldType !== $data->newType &&
            $data->hasPositionChanges() &&
            $data->canAutoManageOldType() => $data->getOldActionableIds(),

            $data->oldType instanceof CharacterType &&
            $data->oldType !== $data->newType &&
            ! $data->hasPositionChanges() &&
            $data->canAutoManageOldType() &&
            ! $data->canAutoManageNewType() => $data->oldPositions?->map(fn (Position $position): int => $position->id)->values()->all(),

            default => [],
        };

        $this->decrement($decrementData ?? []);
        $this->increment($incrementData ?? []);
    }

    /**
     * @param  array<int, int>  $ids
     */
    protected function decrement(array $ids): void
    {
        Position::query()
            ->whereIn('id', $ids)
            ->where('available', '>', 0)
            ->decrement('available');
    }

    /**
     * @param  array<int, int>|null  $ids
     */
    protected function increment(?array $ids): void
    {
        Position::query()
            ->whereIn('id', $ids)
            ->increment('available');
    }
}
