<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ToggleDarkMode
{
    use AsAction;

    public function handle(): void
    {
        $user = auth()->user();

        tap($user)->update([
            'dark_mode' => ! $user->dark_mode,
        ]);
    }
}
