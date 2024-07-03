<?php

declare(strict_types=1);

namespace Nova\Forms\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ResponseValue implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return match ($model->field_type) {
            default => $value,
        };
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return match ($model->field_type) {
            default => $value,
        };
    }
}
