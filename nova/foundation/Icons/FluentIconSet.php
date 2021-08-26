<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class FluentIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add',
            'add-alt' => 'add-circle',
            'alert' => 'error-circle',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circle',
            'arrow-sort' => 'arrow-sort',
            'book' => 'class',
            'calendar' => 'calendar',
            'check' => 'checkmark',
            'check-alt' => 'checkmark-circle',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'clock' => 'clock',
            'close' => 'dismiss',
            'close-alt' => 'dismiss-circle',
            'copy' => 'document-copy',
            'dashboard' => 'glance',
            'delete' => 'delete',
            'duplicate' => 'hide-slide',
            'edit' => 'edit',
            'email' => 'mail',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-hide',
            'home' => 'home',
            'image' => 'image',
            'image-add' => 'image-add',
            'info' => 'info',
            'lightbulb' => 'lightbulb',
            'list' => 'list',
            'location' => 'location',
            'lock' => 'lock',
            'menu' => 'navigation',
            'more' => 'more',
            'move-down' => 'swipe-down',
            'move-right' => 'swipe-right',
            'move-up' => 'swipe-up',
            'note' => 'note',
            'notification' => 'alert',
            'preferences' => 'settings-dev',
            'remove' => 'remove',
            'remove-alt' => 'block',
            'reorder' => 'reorder',
            'search' => 'search',
            'settings' => 'settings',
            'show' => 'eye-show',
            'sign-in' => 'person-leave',
            'sign-out' => 'sign-out',
            'star' => 'star',
            'thumbs-down' => 'thumbs-down',
            'thumbs-up' => 'thumbs-up',
            'user' => 'person',
            'users' => 'people',
            'warning' => 'warning',
            'write' => 'compose',
        ];
    }

    public function name(): string
    {
        return 'Fluent Icons';
    }

    public function prefix(): string
    {
        return 'fluent';
    }
}
