<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

class ArrMacros
{
    public static function boolean()
    {
        return function (array $target, $key, $default = false) {
            if ($default === null) {
                return filter_var(data_get($target, $key, $default), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            }

            return filter_var(data_get($target, $key, $default), FILTER_VALIDATE_BOOLEAN);
        };
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
}
