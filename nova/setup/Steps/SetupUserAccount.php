<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Request;
use Nova\Users\Models\User;
use Throwable;

class SetupUserAccount extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />';
    }

    public function title(): string
    {
        return 'Setup my account';
    }

    public function isComplete(): bool
    {
        try {
            return User::count() > 0;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function isCurrent(): bool
    {
        return Request::is('setup/setup-account');
    }
}
