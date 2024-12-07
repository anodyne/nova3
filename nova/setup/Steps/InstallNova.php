<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Request;
use Nova\Foundation\Nova;

class InstallNova extends Step
{
    public function incompleteIcon(): string
    {
        return '<path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z" />';
    }

    public function title(): string
    {
        return 'Install Nova';
    }

    public function isComplete(): bool
    {
        return Nova::isInstalled();
    }

    public function isCurrent(): bool
    {
        return Request::is('setup/install');
    }
}
