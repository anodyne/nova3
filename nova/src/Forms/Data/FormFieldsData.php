<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Bag\Bag;

/**
 * @method static static from(array $fields)
 */
readonly class FormFieldsData extends Bag
{
    public function __construct(
        public array $fields
    ) {}
}
