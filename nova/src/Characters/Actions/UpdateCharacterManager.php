<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Actions\UpdateFormSubmission;
use Spatie\Activitylog\Facades\LogBatch;

class UpdateCharacterManager
{
    use AsAction;

    public function handle(
        Character $character,
        UpdateCharacterRequest $request
    ): Character {
        return DB::transaction(function () use ($character, $request) {
            LogBatch::startBatch();

            $oldCharacterType = $character->type;
            $oldCharacterPositions = $character->positions;

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

            $characterPositionsData = new CharacterPositionsData(
                character: $character,
                oldType: $oldCharacterType,
                newType: $character->type,
                oldPositions: $oldCharacterPositions,
                newPositions: $character->positions,
            );

            UpdatePositionAvailability::run($characterPositionsData);

            UploadCharacterAvatar::run($character, $request->image_path);

            $this->updateFormSubmission($character, $request->input('characterBio', []));

            LogBatch::endBatch();

            return $character->refresh();
        });
    }

    /** @param array<string, mixed> $data */
    protected function updateFormSubmission(Character $character, array $data = []): void
    {
        $submission = UpdateFormSubmission::run($character->characterFormSubmission);

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
