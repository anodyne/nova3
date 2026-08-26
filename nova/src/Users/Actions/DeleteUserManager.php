<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Actions\DeleteStatusHistory;
use Nova\Users\Models\User;

class DeleteUserManager
{
    use AsAction;

    public function handle(User $user): User
    {
        return DB::transaction(function () use ($user): User {
            DeleteUserCharacters::run($user);

            DeleteUserLogins::run($user);

            DeleteStatusHistory::run($user);

            DeleteUser::run($user);

            return $user;
        });
    }
}
