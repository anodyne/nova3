<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class StreamlineUiIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add-square',
            'alert' => 'alert-warning',
            'arrow-right' => 'arrow-right-circle',
            'arrow-sort' => 'arrows-vertical',
            'book' => 'book-open',
            'calendar' => 'calendar',
            'check' => 'check-square',
            'clock' => 'clock',
            'close' => 'delete-square',
            'copy' => 'file-double',
            'dashboard' => 'gauge',
            'delete' => 'delete-bin',
            'edit' => 'edit-pencil',
            'email' => 'at-sign',
            'filter' => 'filter',
            'folder' => 'folder',
            'hide' => 'view-off',
            'image' => 'picture-landscape',
            'info' => 'info-circle',
            'lightbulb' => 'light-bulb',
            'list' => 'list',
            'location' => 'location-pin',
            'lock' => 'lock',
            'menu' => 'menu',
            'move-down' => 'arrow-bend-down-right',
            'move-right' => 'arrow-bend-right-down',
            'move-up' => 'arrow-bend-up-right',
            'note' => 'book-edit',
            'notification' => 'alert-bell',
            'remove' => 'remove-square',
            'search' => 'search',
            'settings' => 'settings-slider',
            'show' => 'view',
            'sign-in' => 'login-circle',
            'sign-out' => 'logout-circle',
            'star' => 'favorite-star',
            'user' => 'user-single',
            'users' => 'user-multiple',
            'warning' => 'alert-warning-triangle',
            'write' => 'edit-write-circle',
        ];
    }

    public function name(): string
    {
        return 'Streamline UI';
    }

    public function prefix(): string
    {
        return 'sui';
    }
}
