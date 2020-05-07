<?php

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'activity' => 'activity',
            'alert' => 'alert-circle',
            'book' => 'book-open',
            'check' => 'check-circle',
            'edit' => 'edit',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'more' => 'more-horizontal',
            'notification' => 'bell',
            'search' => 'search',
            'show' => 'eye',
            'sidebar' => 'sidebar',
            'trash' => 'trash',
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
