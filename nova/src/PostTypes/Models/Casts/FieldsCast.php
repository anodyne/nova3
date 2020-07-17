<?php

namespace Nova\PostTypes\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\PostTypes\DataTransferObjects\Fields;

class FieldsCast extends DTOCast
{
    public function dtoClass(): string
    {
        return Fields::class;
    }
}
