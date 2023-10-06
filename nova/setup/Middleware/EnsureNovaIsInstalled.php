<?php

declare(strict_types=1);

namespace Nova\Setup\Middleware;

use Closure;
use Illuminate\Http\Request;
use Nova\Foundation\Nova;
use Symfony\Component\HttpFoundation\Response;

class EnsureNovaIsInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Nova::isInstalled() && ! $request->is('setup*')) {
            return redirect('setup');
        }

        return $next($request);
    }
}
