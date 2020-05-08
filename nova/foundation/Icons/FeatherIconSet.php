<?php

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus-circle',
            'alert' => 'alert-circle',
            'book' => 'book-open',
            'check' => 'check-circle',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'close' => 'x-circle',
            'copy' => 'copy',
            'dashboard' => 'activity',
            'delete' => 'trash-2',
            'edit' => 'edit',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'home' => 'home',
            'lock' => 'lock',
            'more' => 'more-horizontal',
            'notification' => 'bell',
            'search' => 'search',
            'show' => 'eye',
            'sidebar' => 'sidebar',
            'sign-out' => 'log-out',
            'user' => 'user',
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
