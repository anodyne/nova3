<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class UnbanUserManager
{
    use AsAction;

    public function handle(User $user): User
    {
        return DB::transaction(function () use ($user) {
            $user->unban();

            activity()
                ->performedOn($user)
                ->event('unbanned')
                ->log('unbanned');

            return $user->fresh();
        });
    }
}
