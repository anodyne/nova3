<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class DeleteUserManager extends Action
{
    public function handle(User $user): User
    {
        return DB::transaction(function () use ($user): User {
            DeleteUserCharacters::run($user);

            DeleteUser::run($user);

            return $user;
        });
    }
}
