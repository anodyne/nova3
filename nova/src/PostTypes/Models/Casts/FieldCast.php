<?php

namespace Nova\PostTypes\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\PostTypes\DataTransferObjects\Field;

class FieldCast extends DTOCast
{
    public function dtoClass(): string
    {
        return Field::class;
    }
}
