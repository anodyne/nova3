<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ToggleDarkMode
{
    use AsAction;

    public function handle(): string
    {
        $user = auth()->user();

        $appearance = $user->appearance === 'light' ? 'dark' : 'light';

        tap($user)->update([
            'appearance' => $appearance,
        ]);

        return $appearance;
    }
}
