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
            'desktop' => 'desktop',
            'drop' => 'drop',
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
            'mature' => 'rating-mature',
            'menu' => 'navigation',
            'moon' => 'moon',
            'move-down' => 'swipe-down',
            'move-right' => 'swipe-right',
            'move-up' => 'swipe-up',
            'note' => 'note',
            'notification' => 'alert',
            'number' => 'number-symbol-square',
            'paint-bucket' => 'paint-bucket',
            'preferences' => 'settings-dev',
            'remove' => 'block',
            'search' => 'search',
            'settings' => 'settings',
            'show' => 'eye-show',
            'sign-in' => 'person-leave',
            'sign-out' => 'sign-out',
            'star' => 'star',
            'start' => 'play',
            'stop' => 'stop',
            'sun' => 'sun',
            'timer' => 'timer',
            'user' => 'person',
            'user-add' => 'person-add',
            'users' => 'people',
            'warning' => 'warning',
            'wrench' => 'wrench',
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
