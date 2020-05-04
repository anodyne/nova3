<?php

namespace Extensions\Anodyne\BootstrapIconSet;

use Nova\Foundation\Icons\IconSet;

class BootstrapIconSet extends IconSet
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
        return 'Bootstrap';
    }

    public function prefix(): string
    {
        return 'bootstrap';
    }
}
