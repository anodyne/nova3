<?php

namespace Extensions\Anodyne\FontAwesomeSolidIconSet;

use Nova\Foundation\Icons\IconSet;

class FontAwesomeSolidIconSet extends IconSet
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
        return 'Font Awesome Solid';
    }

    public function prefix(): string
    {
        return 'fas';
    }
}
