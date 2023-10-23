<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\Date;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Models\Legacy\User as LegacyUser;
use Nova\Setup\Models\Upgrade;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

class MigrateUsers
{
    use AsAction;

    public function handle(): void
    {
        LegacyUser::query()
            ->cursor()
            ->each(function (LegacyUser $legacyUser) {
                $user = User::create([
                    'name' => $legacyUser->name,
                    'email' => $legacyUser->email,
                    'status' => match ($legacyUser->status) {
                        'inactive' => Inactive::class,
                        'pending' => Pending::class,
                        default => Active::class,
                    },
                    'created_at' => $date = $legacyUser->join_date ? Date::createFromTimestamp($legacyUser->join_date) : null,
                    'updated_at' => $legacyUser->last_update ? Date::createFromTimestamp($legacyUser->last_update) : $date,
                ]);

                Upgrade::create([
                    'type' => 'user',
                    'old_id' => $legacyUser->userid,
                    'new_id' => $user->id,
                ]);
            });
    }
}
