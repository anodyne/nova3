<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Pipeline\Pipeline;
use Mistralys\VersionParser\VersionParser;
use Nova\Foundation\Nova;

if (! function_exists('gate')) {
    function gate()
    {
        return app(GateContract::class);
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

if (! function_exists('theme')) {
    function theme(?string $property = null)
    {
        $theme = app('nova.theme');

        return match ($property) {
            'model' => $theme->getModel(),
            'settings' => $theme->getModel()->settings,
            default => $theme,
        };
    }
}

if (! function_exists('theme_path')) {
    function theme_path($path = '')
    {
        return app()->themePath($path);
    }
}

if (! function_exists('addon')) {
    function addon(string $location)
    {
        $className = "Addons\\$location\\Addon";

        if (! class_exists($className)) {
            return null;
        }

        return new $className;
    }
}

if (! function_exists('addon_path')) {
    function addon_path($path = '')
    {
        return app()->addonPath($path);
    }
}

if (! function_exists('rank_path')) {
    function rank_path($path = '')
    {
        return app()->rankPath($path);
    }
}

if (! function_exists('get_class_name')) {
    function get_class_name($value)
    {
        $parts = explode('\\', $value);

        return array_pop($parts);
    }
}

if (! function_exists('external_content')) {
    function external_content($key, $default = null)
    {
        $subject = data_get(cache('external-content'), $key, $default);

        if (blank($subject)) {
            return null;
        }

        $version = VersionParser::create(Nova::filesVersion());

        return parse(
            subject: $subject,
            variables: [
                'versionLong' => $version->getTagVersion(),
                'versionShort' => sprintf('%s.%s', $version->getMajorVersion(), $version->getMinorVersion()),
            ]
        );
    }
}

if (! function_exists('parse')) {
    function parse(string $subject, array $variables, string $escapeChar = '@', $errPlaceholder = null)
    {
        $esc = preg_quote($escapeChar);
        $expr = "/
            $esc$esc(?=$esc*+{)
          | $esc{
          | {(\w+)}
        /x";

        $callback = function ($match) use ($variables, $escapeChar, $errPlaceholder) {
            switch ($match[0]) {
                case $escapeChar.$escapeChar:
                    return $escapeChar;

                case $escapeChar.'{':
                    return '{';

                default:
                    if (isset($variables[$match[1]])) {
                        return $variables[$match[1]];
                    }

                    return isset($errPlaceholder) ? $errPlaceholder : $match[0];
            }
        };

        return preg_replace_callback($expr, $callback, $subject);
    }
}
