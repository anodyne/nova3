<?php

declare(strict_types=1);

namespace Nova\Foundation\Support;

use Bag\Bag;
use Nova\Foundation\Models\Model;

/**
 * @method static static from(Model $model, array $payload)
 */
readonly class FactoryRequestData extends Bag
{
    public function __construct(
        public Model $model,
        public array $payload,
    ) {}
}
