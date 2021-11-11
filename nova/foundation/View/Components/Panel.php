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
        return view('components.panel');
    }

    protected function panelStyles(): string
    {
        return match ($this->as) {
            default => 'bg-gray-1 shadow',
            'light well' => 'bg-gray-3',
            'well' => 'bg-gray-6',
        };
    }
}
