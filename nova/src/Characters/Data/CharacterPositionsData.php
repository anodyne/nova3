<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Bag;
use Illuminate\Support\Collection;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

/**
 * @method static static from(Character $character, ?CharacterType $oldType, ?CharacterType $newType, ?Collection $oldPositions, ?Collection $newPositions, ?string $oldStatus, ?string $newStatus)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class CharacterPositionsData extends Bag
{
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

    public function getNewActionableIds(): array
    {
        return $this->newPositions
            ?->when($this->oldPositions !== null, fn ($collection) => $collection->diff($this->oldPositions))
            ->pluck('id')
            ->all() ?? [];
    }

    public function getOldActionableIds(): array
    {
        return $this->oldPositions
            ?->when($this->newPositions !== null, fn ($collection) => $collection->diff($this->newPositions))
            ->pluck('id')
            ->all() ?? [];
    }

    public function hasPositionChanges(): bool
    {
        return count($this->getOldActionableIds()) > 0 ||
            count($this->getNewActionableIds()) > 0;
    }
}
