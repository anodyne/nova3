<?php

declare(strict_types=1);

use Carbon\CarbonInterface;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Pipeline\Pipeline;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Toast;

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

if (! function_exists('format_date')) {
    function format_date(?CarbonInterface $date, bool $tooltip = true)
    {
        if (blank($date)) {
            return $date;
        }

        $html = html()
            ->element('time')
            ->text($date?->format(settings('general')->phpDateFormat()))
            ->attribute('datetime', $date);

        if ($tooltip) {
            return $html->attribute('x-tooltip.delay.1000-100.raw', $date);
        }

        return $html;
    }
}

if (! function_exists('gate')) {
    function gate()
    {
        return app(GateContract::class);
    }
}

if (! function_exists('icon')) {
    function icon(string $name, string $size = 'md', string $class = '', array $attributes = [])
    {
        return app(Icon::class)->make(
            name: $name,
            size: $size,
            class: $class,
            attributes: $attributes
        );
    }
}

if (! function_exists('iconName')) {
    function iconName(string $name)
    {
        return icon($name)->name();
    }
}

if (! function_exists('pipe')) {
    function pipe($passable)
    {
        return app(Pipeline::class)->send($passable);
    }
}

if (! function_exists('settings')) {
    function settings($key = null)
    {
        $settings = app('nova.settings');

        if ($key) {
            return data_get($settings, $key);
        }

        return $settings;
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
        return app('nova');
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
