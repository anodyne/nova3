<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Users\Models\User;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $form = Form::key('characterBio')->first();

        $users = User::query()->whereIn('id', [1, 2, 4])->get()->keyBy('id');
        $positions = Position::query()->whereIn('id', [1, 2, 31])->get()->keyBy('id');

        $attachUsers = function (Character $character, array $pairs): void {
            $pivot = [];
            foreach ($pairs as $pair) {
                $pivot[$pair['id']] = array_key_exists('primary', $pair) ? ['primary' => (bool) $pair['primary']] : [];
            }
            if ($pivot !== []) {
                $character->users()->attach($pivot);
            }
        };

        $attachPositions = function (Character $character, array $ids) use ($positions): void {
            $ids = array_values(array_intersect($ids, $positions->keys()->all()));
            if ($ids !== []) {
                $character->positions()->attach($ids);
            }
        };

        $picard = Character::factory()->secondary()->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => 1,
        ]);
        if ($users->has(1)) {
            $attachUsers($picard, [['id' => 1]]);
        }
        CreateFormSubmission::run($form, $picard);
        TrackStatusUpdate::run($picard);

        $riker = Character::factory()->primary()->create([
            'name' => 'William Riker',
            'rank_id' => 1,
        ]);
        $attachUsers($riker, array_values(array_filter([
            $users->has(2) ? ['id' => 2] : null,
            $users->has(4) ? ['id' => 4, 'primary' => true] : null,
        ])));
        CreateFormSubmission::run($form, $riker);
        TrackStatusUpdate::run($riker);

        $laforge = Character::factory()->primary()->create([
            'name' => 'Geordi LaForge',
            'rank_id' => 4,
        ]);
        if ($users->has(2)) {
            $attachUsers($laforge, [['id' => 2, 'primary' => true]]);
        }
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
        $attachPositions($shaw, [1]);
        if ($users->has(1)) {
            $attachUsers($shaw, [['id' => 1, 'primary' => true]]);
        }
        CreateFormSubmission::run($form, $shaw);
        TrackStatusUpdate::run($shaw);

        $seven = Character::factory()->primary()->create([
            'name' => 'Seven of Nine',
            'rank_id' => 6,
        ]);
        $attachPositions($seven, [2]);
        if ($users->has(2)) {
            $attachUsers($seven, [['id' => 2, 'primary' => true]]);
        }
        CreateFormSubmission::run($form, $seven);
        TrackStatusUpdate::run($seven);

        $sidney = Character::factory()->secondary()->create([
            'name' => 'Sidney LaForge',
            'rank_id' => 10,
        ]);
        if ($users->has(2)) {
            $attachUsers($sidney, [['id' => 2]]);
        }
        $attachPositions($sidney, [31]);
        CreateFormSubmission::run($form, $sidney);
        TrackStatusUpdate::run($sidney);

        $alandra = Character::factory()->secondary()->create([
            'name' => 'Alandra LaForge',
            'rank_id' => 24,
        ]);
        if ($users->has(2)) {
            $attachUsers($alandra, [['id' => 2]]);
        }
        CreateFormSubmission::run($form, $alandra);
        TrackStatusUpdate::run($alandra);

        $jack = Character::factory()->pending()->create([
            'name' => 'Jack Crusher',
        ]);
        CreateFormSubmission::run($form, $jack);

        activity()->enableLogging();
    }
}
