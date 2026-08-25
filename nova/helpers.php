<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Mistralys\VersionParser\VersionParser;
use Nova\Addons\BaseAddon;
use Nova\Foundation\Application;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Nova;
use Nova\Foundation\NovaManager;
use Nova\Settings\Models\Settings;

if (! function_exists('__s')) {
    function __s(string $key): Stringable
    {
        return str(trans($key));
    }
}

if (! function_exists('gate')) {
    function gate(): GateContract
    {
        return app(GateContract::class);
    }
}

if (! function_exists('pipe')) {
    function pipe(mixed $passable): Pipeline
    {
        return app(Pipeline::class)->send($passable);
    }
}

if (! function_exists('settings')) {
    /**
     * @return ($key is null ? Settings|null : mixed)
     */
    function settings(?string $key = null): mixed
    {
        $settings = app('nova.settings');

        if ($key !== null) {
            return data_get($settings, $key);
        }

        return $settings;
    }
}

if (! function_exists('nova')) {
    function nova(): NovaManager
    {
        return app('nova');
    }
}

if (! function_exists('nova_path')) {
    function nova_path(string $path = ''): string
    {
        $application = app();

        if (! $application instanceof Application) {
            throw new LogicException('Expected the Nova application instance.');
        }

        return $application->novaPath($path);
    }
}

if (! function_exists('theme')) {
    function theme(?string $property = null): mixed
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
    function theme_path(string $path = ''): string
    {
        $application = app();

        if (! $application instanceof Application) {
            throw new LogicException('Expected the Nova application instance.');
        }

        return $application->themePath($path);
    }
}

if (! function_exists('addon')) {
    function addon(string $location): ?BaseAddon
    {
        $className = "Addons\\$location\\Addon";

        if (! is_subclass_of($className, BaseAddon::class)) {
            return null;
        }

        return new $className;
    }
}

if (! function_exists('addon_path')) {
    function addon_path(string $path = ''): string
    {
        $application = app();

        if (! $application instanceof Application) {
            throw new LogicException('Expected the Nova application instance.');
        }

        return $application->addonPath($path);
    }
}

if (! function_exists('rank_path')) {
    function rank_path(string $path = ''): string
    {
        $application = app();

        if (! $application instanceof Application) {
            throw new LogicException('Expected the Nova application instance.');
        }

        return $application->rankPath($path);
    }
}

if (! function_exists('get_class_name')) {
    function get_class_name(string $value): string
    {
        return class_basename($value);
    }
}

if (! function_exists('external_content')) {
    function external_content(string $key, mixed $default = null): ?string
    {
        $subject = data_get(Cache::get(CacheKeys::ExternalContent->value), $key, $default);

        if (! is_string($subject) || blank($subject)) {
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
    /** @param array<string, string> $variables */
    function parse(string $subject, array $variables, string $escapeChar = '@', ?string $errPlaceholder = null): string
    {
        $esc = preg_quote($escapeChar);
        $expr = "/
            $esc$esc(?=$esc*+{)
          | $esc{
          | {(\w+)}
        /x";

        $callback = function (array $match) use ($variables, $escapeChar, $errPlaceholder): string {
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

        return preg_replace_callback($expr, $callback, $subject) ?? $subject;
    }
}
