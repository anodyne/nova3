<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Nova;
use Symfony\Component\HttpFoundation\Response;

class CheckVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            if (Cache::missing('nova-latest-version')) {
                $upstream = Http::get('https://anodyne-productions.com/api/nova/latest-version')->json();

                // First, upstream needs to be higher than current
                // Second, notify if it's a critical update
                // Third, notify only if it matches what the GM wants to be notified of
                if (
                    version_compare($upstream['version'], nova()->version, '>') &&
                    ($upstream['severity'] === 'critical' || in_array($upstream['severity'], settings('general.updateSeverity')))
                ) {
                    Cache::rememberForever('nova-update-available', function () {
                        return true;
                    });
                }

                Cache::put('nova-latest-version', $upstream, now()->addDay());
            }
        }

        return $next($request);
    }
}
