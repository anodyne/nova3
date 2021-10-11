<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class IconlyCurvedIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus',
            'alert' => 'danger-square',
            'arrow-right' => 'arrow-right-square',
            'arrow-sort' => 'swap',
            'book' => 'bookmark',
            'calendar' => 'calendar',
            'check' => 'tick-square',
            'clock' => 'time-square',
            'close' => 'close-square',
            'copy' => 'plus',
            'dashboard' => 'activity',
            'delete' => 'delete',
            'edit' => 'edit',
            'email' => 'send',
            'filter' => 'filter-2',
            'folder' => 'folder',
            'hide' => 'hide',
            'image' => 'image',
            'info' => 'info-square',
            'lightbulb' => 'discovery',
            'list' => 'paper',
            'location' => 'location',
            'lock' => 'lock',
            'menu' => 'more-square',
            'move-down' => 'arrow-down-3',
            'move-right' => 'arrow-right-3',
            'move-up' => 'arrow-up-3',
            'note' => 'document',
            'notification' => 'notification',
            'remove' => 'close-square',
            'search' => 'search',
            'settings' => 'filter',
            'show' => 'show',
            'sign-in' => 'login',
            'sign-out' => 'logout',
            'star' => 'star',
            'user' => 'profile',
            'users' => '3-user',
            'warning' => 'danger-triangle',
            'write' => 'edit-square',
        ];
    }

    public function name(): string
    {
        return 'Iconly Curved';
    }

    public function prefix(): string
    {
        return 'ic';
    }
}
