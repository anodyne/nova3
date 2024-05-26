<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Spatie\LaravelData\Data;

class FormFieldsData extends Data
{
    public function __construct(
        public array $fields
    ) {
    }
}
