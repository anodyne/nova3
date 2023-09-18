<?php

declare(strict_types=1);

namespace Nova\Foundation\Casts;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DateTimeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return $value;
        }

        return CarbonImmutable::parse($value)
            ->setTimezone('America/New_York');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return $value;
        }

        return CarbonImmutable::parse($value)
            ->shiftTimezone('America/New_York')
            ->setTimezone('UTC');
    }
}
