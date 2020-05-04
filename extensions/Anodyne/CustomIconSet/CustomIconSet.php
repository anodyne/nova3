<?php

namespace Extensions\Anodyne\CustomIconSet;

use Nova\Foundation\Icons\IconSet;

class CustomIconSet extends IconSet
{
    public function classes(): string
    {
        return 'stroke-current';
    }

    public function map(): array
    {
        return [
            'activity' => '',
            'book' => '',
            'hide' => '',
            'notification' => '',
            'search' => '',
            'show' => '',
            'sidebar' => '',
        ];
    }

    public function name(): string
    {
        return 'Custom';
    }

    public function prefix(): string
    {
        return 'custom';
    }
}
