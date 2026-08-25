<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;

class ArrMacros
{
    public static function boolean(): Closure
    {
        return function (array $target, $key, $default = false): ?bool {
            if ($default === null) {
                return filter_var(data_get($target, $key, $default), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            }

            return filter_var(data_get($target, $key, $default), FILTER_VALIDATE_BOOLEAN);
        };
    }

    public static function build(): Closure
    {
        return function (array $array): array {
            $items = [];

            foreach ($array as $value => $constraint) {
                if (is_numeric($value)) {
                    $items[] = $constraint;
                } elseif ($constraint) {
                    $items[] = $value;
                }
            }

            return $items;
        };
    }

    public static function isMultiDimensional(): Closure
    {
        return fn (array $array): bool => array_any($array, fn ($item): bool => is_array($item));
    }

    //    public static function enum()
    //    {
    //        return function ($key, $enumClass) {
    //            if ($this->isNotFilled($key) ||
    //                ! function_exists('enum_exists') ||
    //                ! enum_exists($enumClass) ||
    //                ! method_exists($enumClass, 'tryFrom')) {
    //                return null;
    //            }
    //
    //            return $enumClass::tryFrom($this->input($key));
    //        };
    //    }

    public static function randomWeightedElement(): Closure
    {
        return function (array $array) {
            $rand = mt_rand(1, (int) array_sum($array));

            foreach ($array as $key => $value) {
                $rand -= $value;

                if ($rand <= 0) {
                    return $key;
                }
            }
        };
    }
}
