<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Nova;
use Symfony\Component\HttpFoundation\Response;

class CheckNovaVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            Cache::flexible('nova-latest-version', [86_400, 129_600], function () {
                return Http::get(url('api/version'))->json();
            });

            Cache::flexible('nova-update-available', [86_400, 129_600], function () {
                $latestVersion = Cache::get('nova-latest-version');
                $version = data_get($latestVersion, 'version', '0.0');
                $severity = data_get($latestVersion, 'severity');

                if (version_compare(nova()->version, $version, '<')) {
                    return $severity;
                }

                return null;
            });
        }

        return $next($request);
    }
}
