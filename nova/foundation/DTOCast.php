<?php

namespace Nova\Foundation;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Spatie\DataTransferObject\DataTransferObject;

abstract class DTOCast implements CastsAttributes
{
    abstract public function dtoClass(): string;

    public function get($model, $key, $value, $attributes): ?DataTransferObject
    {
        if (! $value) {
            return null;
        }

        $dtoClass = $this->dtoClass();

        return (new $dtoClass(json_decode($value, true)));
    }

    public function set($model, $key, $value, $attributes): string
    {
        $dtoClass = $this->dtoClass();

        if (! $value instanceof $dtoClass) {
            throw new Exception("The provided value must be an instance of {$dtoClass}");
        }

        return json_encode($value->toArray());
    }
}
