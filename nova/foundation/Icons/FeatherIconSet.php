<?php

namespace Nova\Foundation\Icons;

class FeatherIconSet extends IconSet
{
    public function classes(): string
    {
        return 'stroke-current';
    }

    public function map(): array
    {
        return [
            'hide' => 'eye-off',
            'show' => 'eye',
        ];
    }

    public function name(): string
    {
        return 'Feather';
    }

    public function prefix(): string
    {
        return 'feather';
    }
}
