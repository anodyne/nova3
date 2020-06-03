<?php

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus-circle',
            'alert' => 'alert-circle',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circle',
            'book' => 'book-open',
            'check' => 'check',
            'check-alt' => 'check-circle',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'clock' => 'clock',
            'close' => 'x',
            'close-alt' => 'x-circle',
            'copy' => 'copy',
            'dashboard' => 'activity',
            'delete' => 'trash-2',
            'duplicate' => 'copy',
            'edit' => 'edit-2',
            'email' => 'mail',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'home' => 'home',
            'info' => 'info',
            'lock' => 'lock',
            'menu' => 'menu',
            'more' => 'more-horizontal',
            'notification' => 'bell',
            'preferences' => 'sliders',
            'search' => 'search',
            'settings' => 'settings',
            'show' => 'eye',
            'sidebar' => 'sidebar',
            'sign-in' => 'log-in',
            'sign-out' => 'log-out',
            'star' => 'star',
            'user' => 'user',
            'users' => 'users',
            'warning' => 'alert-triangle',
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
