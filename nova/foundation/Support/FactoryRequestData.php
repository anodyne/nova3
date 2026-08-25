<?php

declare(strict_types=1);

namespace Nova\Foundation\Support;

use Bag\Bag;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static static from(Model $model, array<string, mixed> $payload)
 */
readonly class FactoryRequestData extends Bag
{
    public function __construct(
        public Model $model,
        /** @var array<string, mixed> */
        public array $payload,
    ) {}
}
