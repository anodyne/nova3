<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FluentIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add-circle',
            'alert' => 'error-circle',
            'arrow-right' => 'arrow-right-circle',
            'arrow-sort' => 'arrow-sort',
            'book' => 'class',
            'calendar' => 'calendar',
            'check' => 'checkmark-circle',
            'clock' => 'clock',
            'close' => 'dismiss',
            'copy' => 'hide-slide',
            'dashboard' => 'glance',
            'delete' => 'delete',
            'edit' => 'edit',
            'email' => 'mail',
            'filter' => 'filter',
            'folder' => 'folder',
            'hide' => 'eye-hide',
            'image' => 'image',
            'info' => 'info',
            'lightbulb' => 'lightbulb',
            'list' => 'list',
            'location' => 'location',
            'lock' => 'lock',
            'menu' => 'navigation',
            'move-down' => 'swipe-down',
            'move-right' => 'swipe-right',
            'move-up' => 'swipe-up',
            'note' => 'note',
            'notification' => 'alert',
            'remove' => 'block',
            'search' => 'search',
            'settings' => 'settings-dev',
            'show' => 'eye-show',
            'sign-in' => 'person-leave',
            'sign-out' => 'sign-out',
            'star' => 'star',
            'user' => 'person',
            'users' => 'people',
            'warning' => 'warning',
            'write' => 'compose',
        ];
    }

    public function name(): string
    {
        return 'Fluent';
    }

    public function prefix(): string
    {
        return 'fluent';
    }
}
