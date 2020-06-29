<?php

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
            'info' => 'info',
            'lightbulb' => 'lightbulb',
            'list' => 'list',
            'lock' => 'lock',
            'menu' => 'navigation',
            'more' => 'more',
            'notification' => 'alert',
            'preferences' => 'settings-dev',
            'remove' => 'remove',
            'remove-alt' => 'block',
            'reorder' => 'reorder',
            'search' => 'search',
            'settings' => 'settings',
            'show' => 'eye-show',
            'sidebar' => 'sidebar',
            'sign-in' => 'person-leave',
            'sign-out' => 'sign-out',
            'star' => 'star',
            'user' => 'person',
            'users' => 'people',
            'warning' => 'warning',
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
