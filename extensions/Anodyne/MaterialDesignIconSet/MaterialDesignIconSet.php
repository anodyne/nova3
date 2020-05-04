<?php

namespace Extensions\Anodyne\MaterialDesignIconSet;

use Nova\Foundation\Icons\IconSet;

class MaterialDesignIconSet extends IconSet
{
    public function classes(): string
    {
        return 'fill-current';
    }

    public function map(): array
    {
        return [
            'activity' => 'gauge',
            'book' => 'book-open-page-variant',
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
