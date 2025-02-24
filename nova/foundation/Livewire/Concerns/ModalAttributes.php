<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

trait ModalAttributes
{
    public static function attributes(): array
    {
        return [
            // Set the slide-over size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, fullscreen
            'size' => static::size(),
        ];
    }

    public static function size(): string
    {
        return 'lg';
    }
}
