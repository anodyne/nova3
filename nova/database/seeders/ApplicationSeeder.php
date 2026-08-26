<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Nova\Applications\Enums\ApplicationResult;
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
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        DB::transaction(function (): void {
            $forms = Form::query()
                ->whereIn('key', ['userBio', 'characterBio', 'applicationInfo'])
                ->get()
                ->keyBy('key');

            $reviewerIds = array_values(
                User::query()
                    ->orderBy('id')
                    ->limit(3)
                    ->get(['id'])
                    ->map(fn (User $user): string => $user->id)
                    ->all()
            );

            $positionIds = array_values(
                Position::query()
                    ->get(['id'])
                    ->map(fn (Position $position): string => $position->id)
                    ->all()
            );

            $this->makeApplication(
                result: ApplicationResult::Accept,
                forms: $forms,
                reviewerIds: $reviewerIds,
                positionIds: $positionIds
            );

            $this->makeApplication(
                result: ApplicationResult::Deny,
                forms: $forms,
                reviewerIds: $reviewerIds,
                positionIds: $positionIds
            );

            $this->makeApplication(
                result: ApplicationResult::Pending,
                forms: $forms,
                reviewerIds: $reviewerIds,
                positionIds: $positionIds
            );
        });

        activity()->enableLogging();
    }

    /**
     * Build a single application end-to-end (user + character + application + discussion).
     *
     * @param  Collection<string, Form>  $forms
     * @param  list<string>  $reviewerIds
     * @param  list<string>  $positionIds
     */
    protected function makeApplication(
        ApplicationResult $result,
        Collection $forms,
        array $reviewerIds,
        array $positionIds
    ): void {
        $user = User::factory()->pending()->create();
        $user->addRoles(['active', 'writer']);
        PopulateAccountPreferences::run($user);
        PopulateNotificationPreferences::run($user);
        CreateFormSubmission::run($forms['userBio'], $user);

        $character = Character::factory()->primary()->pending()->create();
        $character->users()->attach([$user->id => ['primary' => true]]);

        if ($positionIds) {
            $character->positions()->attach(collect($positionIds)->random());
        }
        CreateFormSubmission::run($forms['characterBio'], $character);

        $appAttributes = [
            'user_id' => $user->id,
            'character_id' => $character->id,
            'result' => $result,
        ];

        if ($result !== ApplicationResult::Pending) {
            $appAttributes['decision_date'] = Date::now()->setMicrosecond(0)->toDateTimeString();
            $appAttributes['decision_message'] = fake()->paragraph();
        }

        $application = Application::factory()->create($appAttributes);
        CreateFormSubmission::run($forms['applicationInfo'], $application);

        $discussion = $application->discussion()->create();
        if ($reviewerIds !== []) {
            $application->reviews()->attach($reviewerIds);
        }

        $this->bulkCreateDiscussionMessages($discussion->id, mt_rand(2, 10), $reviewerIds);
    }

    /**
     * Bulk insert discussion messages for speed.
     *
     * @param  list<string>  $authorPool
     */
    protected function bulkCreateDiscussionMessages(string $discussionId, int $count, array $authorPool): void
    {
        if ($count <= 0) {
            return;
        }

        $authorIds = $authorPool !== []
            ? $authorPool
            : array_values(
                User::query()
                    ->orderBy('id')
                    ->limit(3)
                    ->get(['id'])
                    ->map(fn (User $user): string => $user->id)
                    ->all()
            );

        $now = Date::now()->setMicrosecond(0)->toDateTimeString();

        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'id' => str()->uuid7()->toString(),
                'discussion_id' => $discussionId,
                'content' => fake()->paragraph(),
                'user_id' => $authorIds[array_rand($authorIds)],
                'type' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('discussion_messages')->insert($rows);
    }
}
