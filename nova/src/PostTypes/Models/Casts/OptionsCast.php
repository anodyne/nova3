<?php

namespace Nova\PostTypes\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\PostTypes\DataTransferObjects\Options;

class OptionsCast extends DTOCast
{
    public function dtoClass(): string
    {
        return Options::class;
    }
}
