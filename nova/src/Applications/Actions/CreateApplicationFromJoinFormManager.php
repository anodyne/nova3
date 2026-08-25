<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationData;
use Nova\Applications\Models\Application;
use Nova\Characters\Actions\AssignCharacterOwners;
use Nova\Characters\Actions\AssignCharacterPositions;
use Nova\Characters\Actions\CreateCharacter;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\PublicSite\Requests\StoreApplicationRequest;
use Nova\Users\Actions\CreateUser;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Actions\PopulateUserModerations;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;
use Spatie\Activitylog\Facades\LogBatch;

class CreateApplicationFromJoinFormManager
{
    use AsAction;

    public function handle(StoreApplicationRequest $request): void
    {
        DB::transaction(function () use ($request): void {
            LogBatch::startBatch();

            $character = $this->createPendingCharacter($request);

            $user = $this->findOrCreateUser($request);

            $this->assignCharacterToUser($character, $user);

            $application = $this->createApplication($request, $character, $user);

            LogBatch::endBatch();
        });
    }

    protected function createPendingCharacter(StoreApplicationRequest $request): Character
    {
        $character = CreateCharacter::run($request->getCharacterData());

        $character = AssignCharacterPositions::run(
            $character,
            $request->getCharacterPositionData()
        );

        $this->createFormSubmissionForCharacter($character, $request->input('characterBio', []));

        return $character->refresh();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function createFormSubmissionForCharacter(Character $character, array $data = []): void
    {
        $submission = CreateFormSubmission::run(
            Form::key('characterBio')->first(),
            $character
        );

        SyncFormSubmissionResponses::run($submission, $data);
    }

    protected function findOrCreateUser(StoreApplicationRequest $request): User
    {
        $user = User::where('email', $request->input('userInfo.email'))->first();

        if (blank($user)) {
            $user = CreateUser::run(
                UserData::from(array_merge(
                    $request->input('userInfo'),
                    [
                        'pronouns' => ['value' => 'none'],
                        'moderations' => ['announcements' => false, 'posts' => false],
                    ],
                ))
            );

            $user = PopulateAccountPreferences::run($user);

            $user = PopulateNotificationPreferences::run($user);

            $user = PopulateUserModerations::run($user);

            $this->createFormSubmissionForUser($user, $request->input('userBio', []));

            StartOnboarding::run(OnboardingProcess::NewUser, $user);
        }

        return $user;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function createFormSubmissionForUser(User $user, array $data = []): void
    {
        $submission = CreateFormSubmission::run(
            Form::key('userBio')->first(),
            $user
        );

        SyncFormSubmissionResponses::run($submission, $data);
    }

    protected function assignCharacterToUser(Character $character, User $user): void
    {
        AssignCharacterOwners::run(
            $character,
            new AssignCharacterOwnersData(
                users: [$user->id],
                primaryUsers: [$user->id]
            )
        );

        if ($user->is_pending) {
            $user->characters()->updateExistingPivot($character->id, ['primary' => true]);

            SetCharacterType::run($character->refresh());
        }
    }

    protected function createApplication(StoreApplicationRequest $request, Character $character, User $user): Application
    {
        $applicationData = ApplicationData::from(
            character_id: $character->id,
            user_id: $user->id,
            ip_address: $request->ip(),
        );

        return CreateApplicationManager::run($applicationData, $request->input('applicationInfo', []));
    }
}
