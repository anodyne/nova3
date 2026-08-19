<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Actions\CreateApplicationManager;
use Nova\Applications\Data\ApplicationData;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\StoreCharacterRequest;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Spatie\Activitylog\Facades\LogBatch;

class CreateCharacterManager
{
    use AsAction;

    public function handle(StoreCharacterRequest $request): Character
    {
        return DB::transaction(function () use ($request) {
            LogBatch::startBatch();

            $character = CreateCharacter::run($request->getCharacterData());

            $character = AssignCharacterPositions::run(
                $character,
                $request->getCharacterPositionsData()
            );

            if ($request->user()->can('create', Character::class)) {
                $character = AssignCharacterOwners::run(
                    $character,
                    $request->getCharacterOwnersData()
                );
            } else {
                AssignCharacterOwners::run(
                    $character,
                    $request->getAutoLinkedCharacterOwnersData()
                );
            }

            $character = SetCharacterType::run($character);

            $characterPositionsData = new CharacterPositionsData(
                character: $character,
                newType: $character->type,
                newPositions: $character->positions
            );

            UpdatePositionAvailability::run($characterPositionsData);

            UploadCharacterAvatar::run($character, $request->image_path);

            if ($request->user()->can('activateOnCreation', $character)) {
                $character = ActivateCharacter::run($character);
            }

            $this->createFormSubmission($character, $request->input('characterBio', []));

            $this->createApplication($character);

            SendPendingCharacterNotification::runUnless(
                $character->is_active,
                $character,
                $request->user()
            );

            LogBatch::endBatch();

            return $character->refresh();
        });
    }

    protected function createApplication(Character $character): void
    {
        if ($character->is_pending && $character->activeUsers()->count() > 0) {
            $data = ApplicationData::from(
                character_id: $character->id,
                user_id: $character->activeUsers->first()->id,
                ip_address: null,
            );

            CreateApplicationManager::run($data);
        }
    }

    protected function createFormSubmission(Character $character, ?array $data = []): void
    {
        $submission = CreateFormSubmission::run(
            Form::key('characterBio')->first(),
            $character
        );

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
