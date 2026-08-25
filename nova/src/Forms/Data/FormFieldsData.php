<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Bag\Bag;

/**
 * @method static static from(list<array<string, mixed>> $fields)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class FormFieldsData extends Bag
{
    /**
     * @param  list<array<string, mixed>>  $fields
     */
    public function __construct(
        public array $fields
    ) {}
}
