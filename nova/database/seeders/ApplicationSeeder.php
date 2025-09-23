<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Discussions\Models\Discussion;
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

        $this->createAcceptedApplication();
        $this->createDeniedApplication();
        $this->createPendingApplication();

        activity()->enableLogging();
    }

    protected function createAcceptedApplication(): void
    {
        $user = User::factory()->pending()->create();
        $user->addRoles(['active', 'writer']);
        PopulateAccountPreferences::run($user);
        PopulateNotificationPreferences::run($user);
        CreateFormSubmission::run(Form::key('userBio')->first(), $user);

        $character = Character::factory()->primary()->pending()->create();
        $character->users()->save($user);
        $character->positions()->save(Position::query()->inRandomOrder()->first());
        CreateFormSubmission::run(Form::key('characterBio')->first(), $character);

        $application = Application::factory()
            ->create([
                'user_id' => $user,
                'character_id' => $character,
                'result' => ApplicationResult::Accept,
                'decision_date' => now(),
                'decision_message' => fake()->paragraph(),
            ]);
        CreateFormSubmission::run(Form::key('applicationInfo')->first(), $application);

        $discussion = $application->discussion()->create();

        $application->reviews()->attach([1, 2, 3]);

        $this->createDiscussionMessages($discussion, mt_rand(2, 10));
    }

    protected function createDeniedApplication(): void
    {
        $user = User::factory()->pending()->create();
        $user->addRoles(['active', 'writer']);
        PopulateAccountPreferences::run($user);
        PopulateNotificationPreferences::run($user);
        CreateFormSubmission::run(Form::key('userBio')->first(), $user);

        $character = Character::factory()->primary()->pending()->create();
        $character->users()->save($user);
        $character->positions()->save(Position::query()->inRandomOrder()->first());
        CreateFormSubmission::run(Form::key('characterBio')->first(), $character);

        $application = Application::factory()
            ->create([
                'user_id' => $user,
                'character_id' => $character,
                'result' => ApplicationResult::Deny,
                'decision_date' => now(),
                'decision_message' => fake()->paragraph(),
            ]);
        CreateFormSubmission::run(Form::key('applicationInfo')->first(), $application);

        $discussion = $application->discussion()->create();

        $application->reviews()->attach([1, 2, 3]);

        $this->createDiscussionMessages($discussion, mt_rand(2, 10));
    }

    protected function createPendingApplication(): void
    {
        $user = User::factory()->pending()->create();
        $user->addRoles(['active', 'writer']);
        PopulateAccountPreferences::run($user);
        PopulateNotificationPreferences::run($user);
        CreateFormSubmission::run(Form::key('userBio')->first(), $user);

        $character = Character::factory()->primary()->pending()->create();
        $character->users()->save($user);
        $character->positions()->save(Position::query()->inRandomOrder()->first());
        CreateFormSubmission::run(Form::key('characterBio')->first(), $character);

        $application = Application::factory()
            ->create([
                'user_id' => $user,
                'character_id' => $character,
                'result' => ApplicationResult::Pending,
            ]);
        CreateFormSubmission::run(Form::key('applicationInfo')->first(), $application);

        $discussion = $application->discussion()->create();

        $application->reviews()->attach([1, 2, 3]);

        $this->createDiscussionMessages($discussion, mt_rand(2, 10));
    }

    protected function createDiscussionMessages(Discussion $discussion, int $count = 3): void
    {
        $messages = [];

        for ($i = 0; $i < $count; $i++) {
            $messages[] = [
                'discussion_id' => $discussion->id,
                'content' => fake()->paragraph(),
                'user_id' => mt_rand(1, 3),
                'type' => 'text',
            ];
        }

        $discussion->messages()->createMany($messages);
    }
}
