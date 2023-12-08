<?php

declare(strict_types=1);

namespace Nova\Foundation\Casts;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
            ->setTimezone(Auth::user()?->preferences?->timezone ?? 'UTC');
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
            ->shiftTimezone(Auth::user()?->preferences?->timezone ?? 'UTC')
            ->setTimezone('UTC');
    }
}
