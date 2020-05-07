<?php

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function classes(): string
    {
        return 'stroke-current';
    }

    public function map(): array
    {
        return [
            'activity' => 'activity',
            'alert' => 'alert-circle',
            'book' => 'book-open',
            'check' => 'check-circle',
            'hide' => 'eye-off',
            'notification' => 'bell',
            'search' => 'search',
            'show' => 'eye',
            'sidebar' => 'sidebar',
        ];
    }

    public function name(): string
    {
        return 'Feather';
    }

    public function prefix(): string
    {
        return 'feather';
    }
}
