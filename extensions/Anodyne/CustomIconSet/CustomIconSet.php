<?php

namespace Extensions\Anodyne\CustomIconSet;

use Nova\Foundation\Icons\IconSet;

class CustomIconSet extends IconSet
{
    public function classes(): string
    {
        return 'fill-current';
    }

    public function map(): array
    {
        return [
            'hide' => 'eye-slash',
            'show' => 'eye',
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
