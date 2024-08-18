<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Applications\Events\ApplicationAccepted as ApplicationAcceptedEvent;
use Nova\Applications\Models\Application;
use Nova\Applications\Notifications\ApplicationAccepted;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Actions\UpdateCharacter;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Users\Actions\ActivateUser;

class AcceptApplicationManager
{
    use AsAction;

    public function handle(Application $application, ApplicationDecisionData $data): void
    {
        DB::beginTransaction();

        try {
            ActivateUser::run($user = $application->user);

            UpdateCharacter::run(
                $character = $application->character,
                new CharacterData(
                    name: $character->name,
                    rank_id: $data->rank_id
                )
            );

            AssignCharacterPositions::run(
                $character,
                new AssignCharacterPositionsData(
                    positions: $data->positions
                )
            );

            $character = ActivateCharacter::run($character);

            SetCharacterType::run($character);

            AcceptApplication::run($application, $data->message);

            $user->notify(new ApplicationAccepted($application));

            ApplicationAcceptedEvent::dispatch($application);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }
}
