<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FontAwesomeSolidIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'plus',
            'add-alt' => 'circle-plus',
            'alert' => 'circle-exclamation',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'circle-arrow-right',
            'arrow-sort' => 'arrow-down-arrow-up',
            'book' => 'book-bookmark',
            'calendar' => 'calendar',
            'check' => 'check',
            'check-alt' => 'circle-check',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'clock' => 'clock-three',
            'close' => 'xmark',
            'close-alt' => 'circle-xmark',
            'copy' => 'copy',
            'dashboard' => 'gauge',
            'database' => 'database',
            'delete' => 'trash',
            'duplicate' => 'copy',
            'edit' => 'pen',
            'email' => 'at',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-slash',
            'home' => 'house-chimney',
            'image' => 'image',
            'image-add' => 'image',
            'info' => 'circle-info',
            'lightbulb' => 'lightbulb',
            'list' => 'list',
            'location' => 'location-dot',
            'lock' => 'lock-keyhole',
            'menu' => 'bars-staggered',
            'more' => 'ellipsis',
            'move-down' => 'arrow-down-long',
            'move-right' => 'arrow-right-long',
            'move-up' => 'arrow-up-long',
            'note' => 'note',
            'notification' => 'bell',
            'preferences' => 'sliders',
            'remove' => 'minus',
            'remove-alt' => 'circle-minus',
            'reorder' => 'up-down-left-right',
            'search' => 'magnifying-glass',
            'server' => 'server',
            'settings' => 'gear',
            'show' => 'eye',
            'sign-in' => 'right-to-bracket',
            'sign-out' => 'right-from-bracket',
            'star' => 'star',
            'thumbs-down' => 'thumbs-down',
            'thumbs-up' => 'thumbs-up',
            'user' => 'user',
            'users' => 'users',
            'warning' => 'triangle-exclamation',
            'write' => 'pen-to-square',
        ];
    }

    public function name(): string
    {
        return 'Font Awesome Solid';
    }

    public function prefix(): string
    {
        return 'fas';
    }
}
