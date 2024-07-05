<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Actions\UpdateFormSubmission;

class UpdateCharacterManager
{
    use AsAction;

    public function handle(
        Character $character,
        UpdateCharacterRequest $request
    ): Character {
        $positions = new CharacterPositionsData(
            character: $character,
            previousType: $character->type,
            previousPositions: $character->positions
        );

        $character = UpdateCharacter::run(
            $character,
            $request->getCharacterData()
        );

        $character = AssignCharacterPositions::run(
            $character,
            $request->getCharacterPositionsData()
        );

        $character = AssignCharacterOwners::run(
            $character,
            $request->getCharacterOwnersData()
        );

        $character = SetCharacterType::run($character);

        $positions->currentType = $character->type;
        $positions->currentPositions = $character->positions;

        UpdatePositionAvailability::run($positions);

        UploadCharacterAvatar::run($character, $request->image_path);

        RemoveCharacterAvatar::run($character, $request->boolean('remove_existing_image', false));

        $this->updateFormSubmission($character, $request->input('characterBio'));

        return $character->refresh();
    }

    protected function updateFormSubmission(Character $character, ?array $data = []): void
    {
        $submission = UpdateFormSubmission::run($character->characterFormSubmission);

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
