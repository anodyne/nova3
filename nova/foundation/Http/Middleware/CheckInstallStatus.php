<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Nova\Foundation\Nova;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Nova::isInstalled()) {
            return $next($request);
        }

        return redirect('/setup');
    }
}
