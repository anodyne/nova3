<?php

declare(strict_types=1);

namespace Extensions\Anodyne\MaterialDesignIconSet;

use Nova\Foundation\Icons\IconSet;

class MaterialDesignIconSet extends IconSet
{
    public function map(): array
    {
        return [
            'activity' => 'gauge',
            'alert' => '',
            'book' => 'book-open-page-variant',
            'check' => '',
            'hide' => 'eye-off',
            'notification' => 'bell-outline',
            'search' => 'magnify',
            'show' => 'eye',
            'sidebar' => 'application',
        ];
    }

    public function name(): string
    {
        return 'Material Design';
    }

    public function prefix(): string
    {
        return 'mdi';
    }
}
