<?php

declare(strict_types=1);

namespace Nova\Foundation\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class StateCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
    	return $value->name();
    }
}