<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\User;

class CreateUserManager
{
    use AsAction;

    public function handle(Request $request): User
    {
        $user = CreateUser::run(UserData::fromRequest($request));

        UploadUserAvatar::run($user, $request->avatar_path);

        return $user->fresh();
    }
}
