<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;

class UpdateNova extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />';

        $classes = Arr::toCssClasses([
            'size-6',
            'text-primary-500' => $this->isCurrent(),
            'text-gray-500' => ! $this->isCurrent(),
        ]);

        return new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="'.$classes.'"></svg>');
    }

    public function title(): string
    {
        return 'Update Nova';
    }

    public function isComplete(): bool
    {
        return false;
    }

    public function isCurrent(): bool
    {
        return Request::is('setup/update');
    }
}
