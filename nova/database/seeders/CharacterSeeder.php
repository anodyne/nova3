<?php

namespace Database\Seeders;

use Nova\Users\Models\User;
use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $picard = Character::factory()->primary()->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => 1,
        ]);
        $picard->users()->save(User::find(1), ['primary' => true]);
        $picard->positions()->save(Position::find(1), ['primary' => true]);

        $riker = Character::factory()->primary()->create([
            'name' => 'William Riker',
            'rank_id' => 2,
        ]);
        $riker->users()->save(User::find(2), ['primary' => true]);
        $riker->positions()->save(Position::find(2), ['primary' => true]);

        $data = Character::factory()->create([
            'name' => 'Data',
            'rank_id' => 17,
        ]);
        $data->positions()->save(Position::find(5), ['primary' => true]);

        $laforge = Character::factory()->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 17,
        ]);
        $laforge->positions()->save(Position::find(10), ['primary' => true]);

        $worf = Character::factory()->create([
            'name' => 'Worf',
            'rank_id' => 18,
        ]);
        $worf->positions()->save(Position::find(7), ['primary' => true]);

        $crusher = Character::factory()->create([
            'name' => 'Beverly Crusher',
            'rank_id' => 30,
        ]);
        $crusher->positions()->save(Position::find(13), ['primary' => true]);

        $guinan = Character::factory()->secondary()->create([
            'name' => 'Guinan',
        ]);
        $guinan->users()->saveMany([
            User::find(1),
            User::find(2),
        ]);

        activity()->enableLogging();
    }
}
