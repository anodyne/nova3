<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Bag;
use Illuminate\Support\Collection;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

/**
 * @method static static from(Character $character, ?CharacterType $oldType, ?CharacterType $newType, ?Collection<int, Position> $oldPositions, ?Collection<int, Position> $newPositions, ?string $oldStatus, ?string $newStatus)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class CharacterPositionsData extends Bag
{
    /**
     * @param  Collection<int, Position>|null  $oldPositions
     * @param  Collection<int, Position>|null  $newPositions
     */
    public function __construct(
        public Character $character,
        public ?CharacterType $oldType = null,
        public ?CharacterType $newType = null,
        public ?Collection $oldPositions = null,
        public ?Collection $newPositions = null,
        public ?string $oldStatus = null,
        public ?string $newStatus = null
    ) {}

    public function canAutoManageNewType(): bool
    {
        return settings(sprintf(
            'characters.autoAvailabilityFor%s',
            ucfirst($this->newType->value)
        ));
    }

    public function canAutoManageOldType(): bool
    {
        return settings(sprintf(
            'characters.autoAvailabilityFor%s',
            ucfirst($this->oldType->value)
        ));
    }

    /** @return list<string> */
    public function getNewActionableIds(): array
    {
        return array_values($this->newPositions
            ?->when($this->oldPositions instanceof Collection, fn ($collection) => $collection->diff($this->oldPositions))
            ->map(fn (Position $position): string => $position->id)
            ->values()
            ->all() ?? []);
    }

    /** @return list<string> */
    public function getOldActionableIds(): array
    {
        return array_values($this->oldPositions
            ?->when($this->newPositions instanceof Collection, fn ($collection) => $collection->diff($this->newPositions))
            ->map(fn (Position $position): string => $position->id)
            ->values()
            ->all() ?? []);
    }

    public function hasPositionChanges(): bool
    {
        return count($this->getOldActionableIds()) > 0 ||
            count($this->getNewActionableIds()) > 0;
    }
}
