<?php

namespace Extensions\Anodyne\FluentIconSet;

use Nova\Foundation\Icons\IconSet;

class FluentIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'add' => 'add-circle',
            'alert' => 'error-circle',
            'arrow-right' => 'arrow-right',
            'arrow-right-alt' => 'arrow-right-circle',
            'book' => 'class',
            'check' => 'checkmark',
            'check-alt' => 'checkmark-circle',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-up' => 'chevron-up',
            'close' => 'dismiss',
            'close-alt' => 'dismiss-circle',
            'copy' => 'document-copy',
            'dashboard' => 'glance',
            'delete' => 'delete',
            'duplicate' => 'hide-slide',
            'edit' => 'edit',
            'filter' => 'filter',
            'flag' => 'flag',
            'folder' => 'folder',
            'hide' => 'eye-hide',
            'home' => 'home',
            'info' => 'info',
            'lock' => 'lock',
            'menu' => 'navigation',
            'more' => 'more',
            'notification' => 'alert',
            'preferences' => 'settings-dev',
            'search' => 'search',
            'settings' => 'settings',
            'show' => 'eye-show',
            'sidebar' => 'sidebar',
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
