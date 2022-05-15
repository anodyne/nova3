<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Panel extends Component
{
    public function __construct(
        public string $as = 'panel'
    ) {
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            'sm:rounded-lg',
            $this->panelStyles(),
        ]);
    }

    public function render()
    {
        return view('components.panel.index');
    }

    protected function panelStyles(): string
    {
        return match ($this->as) {
            default => 'bg-white dark:bg-gray-800 shadow dark:shadow-none dark:highlight-white/5 ring-1 ring-gray-900/[.02]',
            'no-shadow' => 'bg-white dark:bg-gray-800 ring-1 ring-gray-900/[.02]',
            'light well' => 'bg-gray-100 dark:bg-gray-700',
            'extra light well' => 'bg-gray-50 dark:bg-gray-700/50',
            'well' => 'bg-gray-200 dark:bg-gray-800',
        };
    }
}
