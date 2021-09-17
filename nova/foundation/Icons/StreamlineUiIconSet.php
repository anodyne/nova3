<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class StreamlineUiIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add',
            'add-alt' => 'add-square',
            'alert' => 'alert-warning',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circle',
            'arrow-sort' => 'arrows-vertical',
            'book' => 'book-open',
            'calendar' => 'calendar',
            'check' => 'check',
            'check-alt' => 'check-square',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'clock' => 'clock',
            'close' => 'delete',
            'close-alt' => 'delete-square',
            'copy' => 'file-double',
            'dashboard' => 'gauge',
            'database' => 'database',
            'delete' => 'delete-bin',
            'duplicate' => 'file-double',
            'edit' => 'edit-pencil',
            'email' => 'at-sign',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'view-off',
            'home' => 'home',
            'image' => 'picture-landscape',
            'image-add' => 'picture-landscape',
            'info' => 'info-circle',
            'lightbulb' => 'light-bulb',
            'list' => 'list',
            'location' => 'location-pin',
            'lock' => 'lock',
            'menu' => 'menu',
            'more' => 'menu-horizontal',
            'move-down' => 'arrow-bend-down-right',
            'move-right' => 'arrow-bend-right-down',
            'move-up' => 'arrow-bend-up-right',
            'note' => 'book-edit',
            'notification' => 'alert-bell',
            'preferences' => 'settings-slider',
            'remove' => 'remove',
            'remove-alt' => 'remove-square',
            'reorder' => 'arrows-vertical-scroll',
            'search' => 'search',
            'server' => 'server',
            'settings' => 'settings-cog',
            'show' => 'view',
            'sign-in' => 'login-circle',
            'sign-out' => 'logout-circle',
            'star' => 'favorite-star',
            'thumbs-down' => 'favorite-dislike',
            'thumbs-up' => 'favorite-like',
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
