<?php

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Characters\Models\States\Types\Pnpc;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Statuses\Inactive;

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
        $picard->type->transitionTo(Primary::class);

        $riker = factory(Character::class)->create([
            'name' => 'William Riker',
            'rank_id' => 2,
        ]);
        $riker->users()->save(User::find(2));
        $riker->positions()->save(Position::find(2));
        $riker->type->transitionTo(Primary::class);

        $data = factory(Character::class)->create([
            'name' => 'Data',
            'rank_id' => 17,
        ]);
        $data->positions()->save(Position::find(5));

        $laforge = factory(Character::class)->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 17,
        ]);
        $laforge->positions()->save(Position::find(10));

        $worf = factory(Character::class)->create([
            'name' => 'Worf',
            'rank_id' => 18,
        ]);
        $worf->positions()->save(Position::find(7));

        $crusher = factory(Character::class)->create([
            'name' => 'Beverly Crusher',
            'rank_id' => 30,
        ]);
        $crusher->positions()->save(Position::find(13));

        $guinan = factory(Character::class)->create([
            'name' => 'Guinan',
        ]);
        $guinan->users()->saveMany([
            User::find(1),
            User::find(2),
        ]);
        $guinan->type->transitionTo(Pnpc::class);

        // $users = User::get();

        // $users->each(function ($user) {
        //     $character = $user->characters()->create(
        //         factory(Character::class)->make()->toArray()
        //     );

        //     $decision = mt_rand(1, 3);

        //     if ($decision === 3) {
        //         $character->status->transitionTo(Inactive::class);
        //     }
        // });

        // factory(Character::class)->times(25)->create()->each(function ($character) {
        //     $decision = mt_rand(1, 3);

        //     if ($decision === 3) {
        //         $character->status->transitionTo(Inactive::class);
        //     }
        // });

        activity()->enableLogging();
    }
}
