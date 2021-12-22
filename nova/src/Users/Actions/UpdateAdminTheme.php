<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class UpdateAdminTheme
{
    use AsAction;

    public function handle(?string $appearance): User
    {
        return tap(auth()->user())->update([
            'appearance' => $appearance,
        ]);
    }
}
