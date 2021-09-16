<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class IconoirIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus',
            'add-alt' => 'add-circled-outline',
            'alert' => 'warning-circled-outline',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circled',
            'arrow-sort' => 'data-transfer-both',
            'book' => 'bookmark-empty',
            'calendar' => 'calendar',
            'check' => 'check',
            'check-alt' => 'check-circled-outline',
            'chevron-down' => 'nav-arrow-down',
            'chevron-left' => 'nav-arrow-left',
            'chevron-right' => 'nav-arrow-right',
            'chevron-up' => 'nav-arrow-up',
            'clock' => 'clock-outline',
            'close' => 'cancel',
            'close-alt' => 'delete-circled-outline',
            'copy' => 'copy',
            'dashboard' => 'dashboard-speed',
            'database' => 'db',
            'delete' => 'trash',
            'duplicate' => 'copy',
            'edit' => 'edit-pencil',
            'email' => 'mail',
            'filter' => 'filter',
            'flag' => 'dash-flag',
            'folder' => 'folder',
            'hide' => 'eye-off',
            'home' => 'home',
            'image' => 'media-image',
            'image-add' => 'add-media-image',
            'info' => 'info-empty',
            'lightbulb' => 'light-bulb',
            'list' => 'list',
            'location' => 'pin-alt',
            'lock' => 'lock',
            'menu' => 'menu',
            'more' => 'more-horiz-circled-outline',
            'move-down' => 'move-down',
            'move-right' => 'move-right',
            'move-up' => 'move-up',
            'note' => 'notes',
            'notification' => 'bell',
            'preferences' => 'settings',
            'remove' => 'minus',
            'remove-alt' => 'remove-empty',
            'reorder' => 'more-vert',
            'search' => 'search',
            'server' => 'server',
            'settings' => 'settings',
            'show' => 'eye-empty',
            'sign-in' => 'log-in',
            'sign-out' => 'log-out',
            'star' => 'star-outline',
            'thumbs-down' => '',
            'thumbs-up' => '',
            'user' => 'user',
            'users' => 'group',
            'warning' => 'warning-triangle-outline',
            'write' => 'edit-pencil',
        ];
    }

    public function name(): string
    {
        return 'Iconoir';
    }

    public function prefix(): string
    {
        return 'iconoir';
    }
}
