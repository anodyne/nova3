<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Illuminate\Support\Collection;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Spatie\LaravelData\Data;

class CharacterPositionsData extends Data
{
    public function __construct(
        public Character $character,
        public ?CharacterType $previousType = null,
        public ?CharacterType $currentType = null,
        public ?Collection $previousPositions = null,
        public ?Collection $currentPositions = null
    ) {}

    public function canAutoManageCurrentType(): bool
    {
        return settings(sprintf(
            'characters.autoAvailabilityFor%s',
            ucfirst($this->currentType->value)
        ));
    }

    public function canAutoManagePreviousType(): bool
    {
        return settings(sprintf(
            'characters.autoAvailabilityFor%s',
            ucfirst($this->previousType->value)
        ));
    }

    public function getCurrentActionableIds(): array
    {
        return $this->currentPositions
            ->when($this->previousPositions !== null, fn ($collection) => $collection->diff($this->previousPositions))
            ->pluck('id')
            ->all();
    }

    public function getPreviousActionableIds(): array
    {
        return $this->previousPositions
            ->when($this->currentPositions !== null, fn ($collection) => $collection->diff($this->currentPositions))
            ->pluck('id')
            ->all();
    }

    public function hasPositionChanges(): bool
    {
        return count($this->getPreviousActionableIds()) > 0 ||
            count($this->getCurrentActionableIds()) > 0;
    }
}
