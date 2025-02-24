<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;
use Nova\Foundation\Nova;

class VerifyServerRequirements extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 10l4 4m0 -4l-4 4" />';

        return new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 fill-white stroke-danger-500"></svg>');
    }

    public function incompleteClasses(): string
    {
        return 'size-6 fill-white text-danger-500';
    }

    public function completeIcon(): string
    {
        if (Nova::environment()->database->driver === 'unknown') {
            return '<path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />';
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
