<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;

class WhatsNew extends Step
{
    public function incompleteIcon(): string
    {
        return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 8a3 3 0 0 1 0 6" /><path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" /><path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />';

        $classes = Arr::toCssClasses([
            'size-6',
            'text-primary-500' => $this->isCurrent(),
            'text-gray-500' => ! $this->isCurrent(),
        ]);

        return new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="'.$classes.'"></svg>');
    }

    public function title(): string
    {
        return 'What’s new?';
    }

    public function isComplete(): bool
    {
        return Request::is('setup/update');
    }

    public function isCurrent(): bool
    {
        return Request::is('setup/update/whats-new');
    }
}
