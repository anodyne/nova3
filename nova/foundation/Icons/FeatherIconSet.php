<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus-circle',
            'alert' => 'alert-circle',
            'arrow-right' => 'arrow-right-circle',
            'arrow-sort' => 'shuffle',
            'book' => 'book-open',
            'calendar' => 'calendar',
            'check' => 'check-circle',
            'clock' => 'clock',
            'close' => 'x-circle',
            'copy' => 'copy',
            'dashboard' => 'activity',
            'delete' => 'trash-2',
            'edit' => 'edit-2',
            'email' => 'mail',
            'filter' => 'filter',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'image' => 'image',
            'info' => 'info',
            'lightbulb' => 'zap',
            'list' => 'list',
            'location' => 'map-pin',
            'lock' => 'lock',
            'menu' => 'menu',
            'move-down' => 'corner-right-down',
            'move-right' => 'corner-down-right',
            'move-up' => 'corner-right-up',
            'note' => 'file-text',
            'notification' => 'bell',
            'remove' => 'minus-circle',
            'search' => 'search',
            'settings' => 'sliders',
            'show' => 'eye',
            'sign-in' => 'log-in',
            'sign-out' => 'log-out',
            'star' => 'star',
            'user' => 'user',
            'users' => 'users',
            'warning' => 'alert-triangle',
            'write' => 'edit',
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
