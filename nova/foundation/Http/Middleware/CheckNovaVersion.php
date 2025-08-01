<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Nova\Foundation\Nova;
use Nova\Foundation\Values\LatestVersion;
use Symfony\Component\HttpFoundation\Response;

class CheckNovaVersion
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            Cache::flexible('nova-latest-version', [86_400, 129_600], function () {
                // TODO: remove this for the 3.0 release
                $latestVersion = Http::get(config('services.anodyne.api.latest-version'))->json();

                if (str(data_get($latestVersion, 'version'))->startsWith('3')) {
                    return LatestVersion::fromAnodyne($latestVersion);
                }

                $url = Str::replaceArray('{id}', ['anodyne/nova3'], config('services.github.api.all-releases'));

                $githubVersion = Http::withHeader('X-GitHub-Api-Version', config('services.github.version'))
                    ->get($url)
                    ->collect()
                    ->first();

                return LatestVersion::fromGithub($githubVersion);
            });

            Cache::flexible('nova-next-version', [86_400, 129_600], function () {
                $nextVersion = Http::get(config('services.anodyne.api.next-version'))->json();

                if (is_null($nextVersion)) {
                    return null;
                }

                return LatestVersion::fromAnodyne($nextVersion);
            });

            Cache::flexible('nova-update-available', [86_400, 129_600], function () {
                $latestVersion = Cache::get('nova-latest-version');

                if (version_compare(Nova::filesVersion(), $latestVersion->version, '<')) {
                    return $latestVersion->severity;
                }

                return null;
            });

            Cache::flexible('nova-update-upcoming', [86_400, 129_600], function () {
                $nextVersion = Cache::get('nova-next-version');

                if (is_null($nextVersion)) {
                    return null;
                }

                if (version_compare(Nova::filesVersion(), $nextVersion->version, '<')) {
                    return $nextVersion->severity;
                }

                return null;
            });
        }

        return $next($request);
    }
}
