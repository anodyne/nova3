<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus',
            'add-alt' => 'plus-circle',
            'alert' => 'alert-circle',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circle',
            'arrow-sort' => 'shuffle',
            'book' => 'book-open',
            'calendar' => 'calendar',
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
            'database' => 'database',
            'delete' => 'trash-2',
            'duplicate' => 'copy',
            'edit' => 'edit-2',
            'email' => 'mail',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'home' => 'home',
            'image' => 'image',
            'image-add' => 'image',
            'info' => 'info',
            'lightbulb' => 'zap',
            'list' => 'list',
            'location' => 'map-pin',
            'lock' => 'lock',
            'menu' => 'menu',
            'more' => 'more-horizontal',
            'move-down' => 'corner-right-down',
            'move-right' => 'corner-down-right',
            'move-up' => 'corner-right-up',
            'note' => 'file-text',
            'notification' => 'bell',
            'preferences' => 'sliders',
            'remove' => 'minus',
            'remove-alt' => 'minus-circle',
            'reorder' => 'more-horizontal',
            'search' => 'search',
            'server' => 'server',
            'settings' => 'settings',
            'show' => 'eye',
            'sign-in' => 'log-in',
            'sign-out' => 'log-out',
            'star' => 'star',
            'thumbs-down' => 'thumbs-down',
            'thumbs-up' => 'thumbs-up',
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
