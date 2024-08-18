<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Models\User;

class ApplicationSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $user = User::factory()->pending()->create([
            'name' => 'Pending user',
            'email' => 'pending@pending.com',
        ]);
        $user->addRoles(['active', 'writer']);
        PopulateAccountPreferences::run($user);
        PopulateNotificationPreferences::run($user);
        CreateFormSubmission::run(Form::key('userBio')->first(), $user);

        $character = Character::factory()->primary()->pending()->create([
            'name' => 'Jean-Luc Picard',
        ]);
        $character->users()->save($user);
        $character->positions()->save(Position::query()->inRandomOrder()->first());
        CreateFormSubmission::run(Form::key('characterBio')->first(), $character);

        $application = Application::factory()
            ->create([
                'user_id' => $user,
                'character_id' => $character,
            ]);
        CreateFormSubmission::run(Form::key('applicationInfo')->first(), $application);

        $application->discussion()->create();

        $application->reviews()->attach([1, 2, 3]);

        activity()->enableLogging();
    }
}
