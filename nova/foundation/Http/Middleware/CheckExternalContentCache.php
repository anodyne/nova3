<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Nova;
use Symfony\Component\HttpFoundation\Response;

class CheckExternalContentCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            Cache::rememberForever('external-content', function () {
                return DB::table('external_content')->get()->pluck('value', 'key')->toArray();
            });

            Cache::rememberForever('external-changelog', function () {
                return ExternalChangelog::get();
            });
        }

        return $next($request);
    }
}
