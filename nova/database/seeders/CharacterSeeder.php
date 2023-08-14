<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Users\Models\User;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $picard = Character::factory()->secondary()->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => 1,
        ]);
        $picard->users()->save(User::find(1));

        $riker = Character::factory()->primary()->create([
            'name' => 'William Riker',
            'rank_id' => 1,
        ]);
        $riker->users()->save(User::find(2));
        $riker->users()->save(User::find(4), ['primary' => true]);

        $laforge = Character::factory()->primary()->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 4,
        ]);
        $laforge->users()->save(User::find(2), ['primary' => true]);

        $worf = Character::factory()->create([
            'name' => 'Worf',
        ]);

        $crusher = Character::factory()->create([
            'name' => 'Beverly Crusher',
            'rank_id' => 4,
        ]);

        $shaw = Character::factory()->primary()->create([
            'name' => 'Liam Shaw',
            'rank_id' => 5,
        ]);
        $shaw->positions()->save(Position::find(1));
        $shaw->users()->save(User::find(1), ['primary' => true]);

        $seven = Character::factory()->primary()->create([
            'name' => 'Seven of Nine',
            'rank_id' => 6,
        ]);
        $seven->positions()->save(Position::find(2));
        $seven->users()->save(User::find(2), ['primary' => true]);

        $sidney = Character::factory()->secondary()->create([
            'name' => 'Sidney LaForge',
            'rank_id' => 10,
        ]);
        $sidney->users()->save(User::find(2));
        $sidney->positions()->save(Position::find(5));

        $alandra = Character::factory()->secondary()->create([
            'name' => 'Alandra LaForge',
            'rank_id' => 24,
        ]);
        $alandra->users()->save(User::find(2));

        $jack = Character::factory()->pending()->create([
            'name' => 'Jack Crusher',
        ]);

        activity()->enableLogging();
    }
}
