<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Nova\Users\Models\User;
use Nova\Users\Requests\StoreUserRequest;

class CreateUserManager
{
    use AsAction;

    public function handle(StoreUserRequest $request): User
    {
        $user = CreateUser::run($request->getUserData());

        if (filled($request->assigned_characters)) {
            $user = SyncUserCharacters::run($user, $request->getUserCharactersData());
        }

        if (filled($request->assigned_roles)) {
            $user = SyncUserRoles::run($user, $request->getUserRolesData());
        }

        $user = PopulateNotificationPreferences::run($user);

        UploadUserAvatar::run($user, $request->image_path);

        $this->createFormSubmission($user, $request->input('userBio'));

        return $user->fresh();
    }

    protected function createFormSubmission(User $user, ?array $data = []): void
    {
        $submission = CreateFormSubmission::run(
            Form::key('userBio')->first(),
            $user
        );

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
