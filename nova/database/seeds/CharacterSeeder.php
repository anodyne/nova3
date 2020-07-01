<?php

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Characters\Models\States\Pnpc;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Primary;
use Nova\Characters\Models\States\Inactive;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $picard = factory(Character::class)->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => 1,
        ]);
        $picard->users()->save(User::find(1));
        $picard->positions()->save(Position::find(1));
        $picard->status->transitionTo(Active::class);
        $picard->type->transitionTo(Primary::class);

        $riker = factory(Character::class)->create([
            'name' => 'William Riker',
            'rank_id' => 2,
        ]);
        $riker->users()->save(User::find(2));
        $riker->positions()->save(Position::find(2));
        $riker->status->transitionTo(Active::class);
        $riker->type->transitionTo(Primary::class);

        $data = factory(Character::class)->create([
            'name' => 'Data',
            'rank_id' => 17,
        ]);
        $data->positions()->save(Position::find(5));
        $data->status->transitionTo(Active::class);

        $laforge = factory(Character::class)->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 17,
        ]);
        $laforge->positions()->save(Position::find(10));
        $laforge->status->transitionTo(Active::class);

        $worf = factory(Character::class)->create([
            'name' => 'Worf',
            'rank_id' => 18,
        ]);
        $worf->positions()->save(Position::find(7));
        $worf->status->transitionTo(Active::class);

        $crusher = factory(Character::class)->create([
            'name' => 'Beverly Crusher',
            'rank_id' => 30,
        ]);
        $crusher->positions()->save(Position::find(13));
        $crusher->status->transitionTo(Active::class);

        $guinan = factory(Character::class)->create([
            'name' => 'Guinan',
        ]);
        $guinan->users()->saveMany([
            User::find(1),
            User::find(2),
        ]);
        $guinan->status->transitionTo(Active::class);
        $guinan->type->transitionTo(Pnpc::class);

        $users = User::get();

        $users->each(function ($user) {
            $character = $user->characters()->create(
                factory(Character::class)->make()->toArray()
            );

            $decision = mt_rand(1, 3);

            // if ($decision === 2) {
            //     $character->status->transitionTo(Active::class);
            // }

            if ($decision === 3) {
                $character->status->transitionTo(Active::class);
                $character->status->transitionTo(Inactive::class);
            }
        });

        factory(Character::class)->times(25)->create()->each(function ($character) {
            $decision = mt_rand(1, 3);

            // if ($decision === 2) {
            //     $character->status->transitionTo(Active::class);
            // }

            if ($decision === 3) {
                $character->status->transitionTo(Active::class);
                $character->status->transitionTo(Inactive::class);
            }
        });

        activity()->enableLogging();
    }
}
