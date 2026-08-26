<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use Lorisleiva\Actions\Concerns\AsObject;
use Nova\Users\Models\User;

class DeleteStatusHistory
{
    use AsObject;

    public function handle(User $user): void
    {
        $user->statusHistories()->delete();
    }
}
