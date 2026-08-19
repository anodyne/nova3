<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;
use Spatie\Activitylog\Facades\LogBatch;

class DeleteUserManager
{
    use AsAction;

    public function handle(User $user): User
    {
        return DB::transaction(function () use ($user): User {
            LogBatch::startBatch();

            DeleteUser::run($user);

            DeleteUserCharacters::run($user);

            LogBatch::endBatch();

            return $user;
        });
    }
}
