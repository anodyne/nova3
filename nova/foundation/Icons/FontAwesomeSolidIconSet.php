<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FontAwesomeSolidIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'circle-plus',
            'alert' => 'circle-exclamation',
            'arrow-right' => 'circle-arrow-right',
            'arrow-sort' => 'arrow-down-arrow-up',
            'book' => 'book-bookmark',
            'calendar' => 'calendar',
            'check' => 'circle-check',
            'clock' => 'clock-three',
            'close' => 'xmark',
            'copy' => 'copy',
            'dashboard' => 'gauge',
            'delete' => 'trash',
            'edit' => 'pen',
            'email' => 'at',
            'filter' => 'filter',
            'folder' => 'folder',
            'hide' => 'eye-slash',
            'image' => 'image',
            'info' => 'circle-info',
            'lightbulb' => 'lightbulb',
            'list' => 'list',
            'location' => 'location-dot',
            'lock' => 'lock-keyhole',
            'menu' => 'bars-staggered',
            'move-down' => 'arrow-down-long',
            'move-right' => 'arrow-right-long',
            'move-up' => 'arrow-up-long',
            'note' => 'note',
            'notification' => 'bell',
            'remove' => 'circle-minus',
            'search' => 'magnifying-glass',
            'settings' => 'sliders',
            'show' => 'eye',
            'sign-in' => 'right-to-bracket',
            'sign-out' => 'right-from-bracket',
            'star' => 'star',
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
