<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class BanUser
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->ban([
            'created_by_type' => 'user',
            'created_by_id' => Auth::id(),
        ]);

        return $user;
    }
}
