<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Users\Models\User;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $form = Form::key('characterBio')->first();

        $picard = Character::factory()->secondary()->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => 1,
        ]);
        $picard->users()->save(User::find(1));
        CreateFormSubmission::run($form, $picard);
        TrackStatusUpdate::run($picard);

        $riker = Character::factory()->primary()->create([
            'name' => 'William Riker',
            'rank_id' => 1,
        ]);
        $riker->users()->save(User::find(2));
        $riker->users()->save(User::find(4), ['primary' => true]);
        CreateFormSubmission::run($form, $riker);
        TrackStatusUpdate::run($riker);

        $laforge = Character::factory()->primary()->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 4,
        ]);
        $laforge->users()->save(User::find(2), ['primary' => true]);
        CreateFormSubmission::run($form, $laforge);
        TrackStatusUpdate::run($laforge);

        $worf = Character::factory()->create([
            'name' => 'Worf',
        ]);
        CreateFormSubmission::run($form, $worf);
        TrackStatusUpdate::run($worf);

        $crusher = Character::factory()->create([
            'name' => 'Beverly Crusher',
            'rank_id' => 4,
        ]);
        CreateFormSubmission::run($form, $crusher);
        TrackStatusUpdate::run($crusher);

        $shaw = Character::factory()->primary()->create([
            'name' => 'Liam Shaw',
            'rank_id' => 5,
        ]);
        $shaw->positions()->save(Position::find(1));
        $shaw->users()->save(User::find(1), ['primary' => true]);
        CreateFormSubmission::run($form, $shaw);
        TrackStatusUpdate::run($shaw);

        $seven = Character::factory()->primary()->create([
            'name' => 'Seven of Nine',
            'rank_id' => 6,
        ]);
        $seven->positions()->save(Position::find(2));
        $seven->users()->save(User::find(2), ['primary' => true]);
        CreateFormSubmission::run($form, $seven);
        TrackStatusUpdate::run($seven);

        $sidney = Character::factory()->secondary()->create([
            'name' => 'Sidney LaForge',
            'rank_id' => 10,
        ]);
        $sidney->users()->save(User::find(2));
        $sidney->positions()->save(Position::find(31));
        CreateFormSubmission::run($form, $sidney);
        TrackStatusUpdate::run($sidney);

        $alandra = Character::factory()->secondary()->create([
            'name' => 'Alandra LaForge',
            'rank_id' => 24,
        ]);
        $alandra->users()->save(User::find(2));
        CreateFormSubmission::run($form, $alandra);
        TrackStatusUpdate::run($alandra);

        $jack = Character::factory()->pending()->create([
            'name' => 'Jack Crusher',
        ]);
        CreateFormSubmission::run($form, $jack);

        activity()->enableLogging();
    }
}
