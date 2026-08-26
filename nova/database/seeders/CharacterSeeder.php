<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        $form = Form::key('characterBio')->first();

        $users = User::query()
            ->whereIn('email', ['admin@admin.com', 'user1@user.com', 'user3@user.com'])
            ->get()
            ->keyBy('email');

        $ranks = RankItem::query()
            ->get()
            ->keyBy(fn (RankItem $rank): string => "{$rank->base_image}|{$rank->overlay_image}");

        $positions = Position::query()
            ->whereIn('name', ['Commanding Officer', 'Executive Officer', 'Engineering Officer'])
            ->get()
            ->keyBy('name');

        $attachUser = function (Character $character, string $email, bool $primary = false) use ($users): void {
            if ($user = $users->get($email)) {
                $character->users()->attach($user->id, [
                    'id' => Str::uuid7()->toString(),
                    'primary' => $primary,
                ]);
            }
        };

        $attachPosition = function (Character $character, string $name) use ($positions): void {
            if ($position = $positions->get($name)) {
                $character->positions()->attach($position->id, [
                    'id' => Str::uuid7()->toString(),
                ]);
            }
        };

        $picard = Character::factory()->secondary()->create([
            'name' => 'Jean-Luc Picard',
            'rank_id' => $ranks['red.png|naval/a4.png']->id,
        ]);
        $attachUser($picard, 'admin@admin.com');
        CreateFormSubmission::run($form, $picard);
        TrackStatusUpdate::run($picard);

        $riker = Character::factory()->primary()->create([
            'name' => 'William Riker',
            'rank_id' => $ranks['red.png|naval/a4.png']->id,
        ]);
        $attachUser($riker, 'user1@user.com');
        $attachUser($riker, 'user3@user.com', primary: true);
        CreateFormSubmission::run($form, $riker);
        TrackStatusUpdate::run($riker);

        $laforge = Character::factory()->primary()->create([
            'name' => 'Geordi LaForge',
            'rank_id' => $ranks['red.png|naval/a1.png']->id,
        ]);
        $attachUser($laforge, 'user1@user.com', primary: true);
        CreateFormSubmission::run($form, $laforge);
        TrackStatusUpdate::run($laforge);

        $worf = Character::factory()->create([
            'name' => 'Worf',
        ]);
        CreateFormSubmission::run($form, $worf);
        TrackStatusUpdate::run($worf);

        $crusher = Character::factory()->create([
            'name' => 'Beverly Crusher',
            'rank_id' => $ranks['red.png|naval/a1.png']->id,
        ]);
        CreateFormSubmission::run($form, $crusher);
        TrackStatusUpdate::run($crusher);

        $shaw = Character::factory()->primary()->create([
            'name' => 'Liam Shaw',
            'rank_id' => $ranks['red.png|naval/o6.png']->id,
        ]);
        $attachPosition($shaw, 'Commanding Officer');
        $attachUser($shaw, 'admin@admin.com', primary: true);
        CreateFormSubmission::run($form, $shaw);
        TrackStatusUpdate::run($shaw);

        $seven = Character::factory()->primary()->create([
            'name' => 'Seven of Nine',
            'rank_id' => $ranks['red.png|naval/o5.png']->id,
        ]);
        $attachPosition($seven, 'Executive Officer');
        $attachUser($seven, 'user1@user.com', primary: true);
        CreateFormSubmission::run($form, $seven);
        TrackStatusUpdate::run($seven);

        $sidney = Character::factory()->secondary()->create([
            'name' => 'Sidney LaForge',
            'rank_id' => $ranks['red.png|naval/o1.png']->id,
        ]);
        $attachUser($sidney, 'user1@user.com');
        $attachPosition($sidney, 'Engineering Officer');
        CreateFormSubmission::run($form, $sidney);
        TrackStatusUpdate::run($sidney);

        $alandra = Character::factory()->secondary()->create([
            'name' => 'Alandra LaForge',
            'rank_id' => $ranks['yellow.png|naval/o2.png']->id,
        ]);
        $attachUser($alandra, 'user1@user.com');
        CreateFormSubmission::run($form, $alandra);
        TrackStatusUpdate::run($alandra);

        $jack = Character::factory()->pending()->create([
            'name' => 'Jack Crusher',
        ]);
        CreateFormSubmission::run($form, $jack);
    }
}
