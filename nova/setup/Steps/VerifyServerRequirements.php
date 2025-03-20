<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Request;
use Nova\Foundation\Nova;

class VerifyServerRequirements extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 10l4 4m0 -4l-4 4" />';
    }

    public function incompleteClasses(): string
    {
        return 'size-6 fill-white text-danger-500';
    }

    public function completeIcon(): string
    {
        if (Nova::environment()->database->driver === 'unknown') {
            return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 16v.01" /><path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />';
        }

        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" />';
    }

    public function completeClasses(): string
    {
        if (Nova::environment()->database->driver === 'unknown') {
            return 'size-6 fill-white text-warning-500';
        }

        return 'size-6 fill-white text-success-500';
    }

    public function title(): string
    {
        return 'Can I run Nova?';
    }

    public function isComplete(): bool
    {
        return Nova::environment()->passes();
    }

    public function isCurrent(): bool
    {
        return Request::is('setup');
    }
}
