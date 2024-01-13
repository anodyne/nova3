<?php

declare(strict_types=1);

namespace Nova\Foundation\Facades;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Facade;
use Nova\Foundation\View\ViewManager;

/**
 * @method static Htmlable renderHook(string $name, string | array | null $scopes = null)
 *
 * @see ViewManager
 */
class NovaView extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ViewManager::class;
    }

    /**
     * @param  string | array<string> | null  $scopes
     */
    public static function registerRenderHook(string $name, Closure $hook, string|array|null $scopes = null): void
    {
        static::resolved(function (ViewManager $viewManager) use ($name, $hook, $scopes) {
            $viewManager->registerRenderHook($name, $hook, $scopes);
        });
    }
}
