<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class BanUserManager
{
    use AsAction;

    public function handle(User $user): User
    {
        return DB::transaction(function () use ($user) {
            BanUser::run($user);

            DeactivateUser::run($user);

            activity()
                ->performedOn($user)
                ->event('banned')
                ->log('banned');

            return $user->fresh();
        });
    }
}
