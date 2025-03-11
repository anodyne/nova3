<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;
use Spatie\Activitylog\Facades\LogBatch;

class ActivateUserManager
{
    use AsAction;

    public function handle(User $user, bool $activatePreviousCharacter = false): User
    {
        return DB::transaction(function () use ($user, $activatePreviousCharacter) {
            LogBatch::startBatch();

            $user = ActivateUser::run($user);

            ActivateUserPreviousCharacter::runIf($activatePreviousCharacter, $user);

            LogBatch::endBatch();

            return $user->refresh();
        });
    }
}
