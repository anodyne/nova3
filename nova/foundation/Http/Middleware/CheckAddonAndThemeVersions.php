<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Nova;
use Nova\Themes\Models\Theme;
use Symfony\Component\HttpFoundation\Response;

class CheckAddonAndThemeVersions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            Cache::flexible('nova-addons-latest-versions', [86_400, 129_600], function () {
                return Addon::query()
                    ->whereNotNull('repository')
                    ->get()
                    ->flatMap(fn (Addon $addon): array => [
                        $addon->repository->id => $addon->repository->endpointData(),
                    ])
                    ->all();
            });

            Cache::flexible('nova-themes-latest-versions', [86_400, 129_600], function () {
                return Theme::query()
                    ->whereNotNull('repository')
                    ->get()
                    ->flatMap(fn (Theme $theme): array => [
                        $theme->repository->id => $theme->repository->endpointData(),
                    ])
                    ->all();
            });
        }

        return $next($request);
    }
}
