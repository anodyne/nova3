<?php

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Inactive;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $users = User::get();

        $users->each(function ($user) {
            $character = $user->characters()->create(
                factory(Character::class)->make()->toArray()
            );

            $decision = mt_rand(1, 3);

            if ($decision === 2) {
                $character->status->transitionTo(Active::class);
            }

            if ($decision === 3) {
                $character->status->transitionTo(Active::class);
                $character->status->transitionTo(Inactive::class);
            }
        });

        factory(Character::class)->times(25)->create()->each(function ($character) {
            $decision = mt_rand(1, 3);

            if ($decision === 2) {
                $character->status->transitionTo(Active::class);
            }

            if ($decision === 3) {
                $character->status->transitionTo(Active::class);
                $character->status->transitionTo(Inactive::class);
            }
        });

        activity()->enableLogging();
    }
}
