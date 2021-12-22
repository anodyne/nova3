<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Pipeline\Pipeline;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Nova;
use Nova\Foundation\Toast;
use Nova\Settings\Models\Settings;

if (! function_exists('blank')) {
    function blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (! function_exists('gate')) {
    function gate()
    {
        return app(GateContract::class);
    }
}

if (! function_exists('icon')) {
    function icon($name, $class = '', array $attributes = [])
    {
        return app(Icon::class)->make($name, $class, $attributes);
    }
}

if (! function_exists('pipe')) {
    function pipe($passable)
    {
        return app(Pipeline::class)->send($passable);
    }
}

if (! function_exists('settings')) {
    function settings()
    {
        if (Nova::isInstalled()) {
            return Settings::custom()->first();
        }

        return null;
    }
}

if (! function_exists('toast')) {
    function toast()
    {
        return app(Toast::class);
    }
}

if (! function_exists('nova')) {
    function nova()
    {
        return app(Nova::class);
    }
}

if (! function_exists('nova_path')) {
    function nova_path($path = '')
    {
        return app()->novaPath($path);
    }
}

if (! function_exists('theme_path')) {
    function theme_path($path = '')
    {
        return app()->themePath($path);
    }
}

if (! function_exists('get_class_name')) {
    function get_class_name($value)
    {
        $parts = explode('\\', $value);

        return array_pop($parts);
    }
}
