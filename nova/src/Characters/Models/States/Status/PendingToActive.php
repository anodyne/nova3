<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Actions\SendPendingCharacterNotification;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Spatie\ModelStates\Transition;

class PendingToActive extends Transition
{
    public function __construct(
        protected Character $character
    ) {
    }

    public function handle(): Character
    {
        $this->character->status = Active::class;
        $this->character->save();

        $this->resetCharacterState();

        // TODO: Decrement available positions if needed

        return $this->character->refresh();
    }

    protected function resetCharacterState()
    {
        // Get a list of users that have this character as their primary character
        User::whereHas('primaryCharacter', fn (Builder $query): Builder => $query->where('characters.id', $this->character->id))
            ->get()
            ->each(function (User $user) {
                $currentUser = auth()->user();

                // If the user has more than 1 primary character...
                if ($user->primaryCharacter()->count() > 1) {
                    // Get the primary characters that are not the character being activated
                    $primaryCharacters = $user->primaryCharacter()
                        ->wherePivot('character_id', '!=', $this->character->id)
                        ->get();

                    if (
                        // If the user can create characters, remove the primary designation
                        $currentUser->can('create', Character::class) ||

                        // If the user can create primary and secondary characters, remove the primary designation
                        (
                            $currentUser->can('createPrimary', Character::class) &&
                            $currentUser->can('createSecondary', Character::class)
                        )
                    ) {
                        $primaryCharacters->each(function (Character $character) use ($user) {
                            $user->primaryCharacter()->updateExistingPivot($character->id, ['primary' => false]);

                            SetCharacterType::run($character);
                        });
                    }

                    // If approval is required for creating secondary characters, set the character being changed to pending and send the notification
                    if (
                        $currentUser->can('createPrimary', Character::class) &&
                        $currentUser->can('createSecondary', Character::class) &&
                        settings('characters.approveSecondary') === true
                    ) {
                        $primaryCharacters->each(function (Character $character) use ($user) {
                            $character->status->transitionTo(Pending::class);

                            SendPendingCharacterNotification::run($character, $user);
                        });
                    }

                    // If the user can create primary, but not create secondary characters, deactivate the primary character
                    if (
                        $currentUser->can('createPrimary', $this->character) &&
                        $currentUser->cannot('createSecondary', $this->character)
                    ) {
                        $primaryCharacters->each(
                            fn (Character $character) => DeactivateCharacter::run($character)
                        );
                    }
                }
            });
    }
}
