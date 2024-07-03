<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Actions\UpdateFormSubmission;
use Nova\Users\Models\User;
use Nova\Users\Requests\UpdateUserRequest;

class UpdateUserManager
{
    use AsAction;

    public function handle(User $user, UpdateUserRequest $request): User
    {
        $user = UpdateUser::run($user, $request->getUserData());

        if (filled($request->assigned_characters)) {
            $user = SyncUserCharacters::run($user, $request->getUserCharactersData());
        }

        if (filled($request->assigned_roles)) {
            $user = SyncUserRoles::run($user, $request->getUserRolesData());
        }

        UploadUserAvatar::run($user, $request->image_path);

        RemoveUserAvatar::run($user, $request->boolean('remove_existing_image', false));

        $this->updateFormSubmission($user, $request->input('user'));

        return $user->refresh();
    }

    protected function updateFormSubmission(User $user, ?array $data = []): void
    {
        $submission = UpdateFormSubmission::run($user->userFormSubmission);

        SyncFormSubmissionResponses::run($submission, $data);
    }
}
