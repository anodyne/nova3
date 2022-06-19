<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Avatar extends Component
{
    public ?string $src;

    public $size;

    public $tooltip;

    public function __construct($src = null, $size = 'md', $tooltip = '')
    {
        $this->src = $src;
        $this->size = $size;
        $this->tooltip = $tooltip;
    }

    public function styles(): string
    {
        return Arr::toCssClasses([
            'inline-block relative rounded-full',
            'bg-white dark:bg-gray-800',
            'ring-2 ring-white dark:ring-gray-800',
            $this->sizeStyles(),
        ]);
    }

    public function sizeStyles(): string
    {
        return match ($this->size) {
            default => 'h-12 w-12',
            'xs' => 'h-8 w-8',
            'sm' => 'h-10 w-10',
            'lg' => 'h-16 w-16',
            'xl' => 'h-24 w-24',
        };
    }

    public function render()
    {
        return view('components.avatar.index');
    }
}
