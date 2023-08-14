<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsObject;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class AutoAvailabilityManager
{
    use AsObject;

    public function handle(
        Character $character,
        AssignCharacterPositionsData $data,
        array $oldPositionIds
    ): void {
        $this->handlePrimaryCharacter($character, $data, $oldPositionIds);

        $this->handleSecondaryCharacter($character, $data, $oldPositionIds);

        $this->handleSupportCharacter($character, $data, $oldPositionIds);
    }

    protected function handlePrimaryCharacter(
        Character $character,
        AssignCharacterPositionsData $data,
        array $oldPositionIds
    ): void {
        if ($character->type === CharacterType::primary && settings('characters.autoAvailabilityForPrimary')) {
            Position::whereIn(
                'id',
                array_diff($data->positions, $oldPositionIds)
            )->decrement('available');

            Position::whereIn(
                'id',
                array_diff($oldPositionIds, $data->positions)
            )->increment('available');
        }
    }

    protected function handleSecondaryCharacter(
        Character $character,
        AssignCharacterPositionsData $data,
        array $oldPositionIds
    ): void {
        if ($character->type === CharacterType::secondary && settings('characters.autoAvailabilityForSecondary')) {
            Position::whereIn(
                'id',
                array_diff($data->positions, $oldPositionIds)
            )->decrement('available');

            Position::whereIn(
                'id',
                array_diff($oldPositionIds, $data->positions)
            )->increment('available');
        }
    }

    protected function handleSupportCharacter(
        Character $character,
        AssignCharacterPositionsData $data,
        array $oldPositionIds
    ): void {
        if ($character->type === CharacterType::support && settings('characters.autoAvailabilityForSupport')) {
            Position::whereIn(
                'id',
                array_diff($data->positions, $oldPositionIds)
            )->decrement('available');

            Position::whereIn(
                'id',
                array_diff($oldPositionIds, $data->positions)
            )->increment('available');
        }
    }
}
