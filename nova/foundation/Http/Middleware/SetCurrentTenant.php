<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laratrust\Laratrust;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->resolveTenant($request);

        app()->instance('currentTenant', $tenant);

        if ($tenant) {
            Laratrust::setCurrentTeam($tenant->id);
        } else {
            Laratrust::setCurrentTeam(null);
        }

        // if ($tenant && $request->route()?->getName()?->startsWith('system.')) {
        //     abort(403, 'System-only route cannot be accessed in tenant context.');
        // }

        return $next($request);
    }

    /**
     * Resolve the tenant from subdomain, route parameter, or session.
     */
    protected function resolveTenant(Request $request): ?Tenant
    {
        // Example 1: from subdomain  → tenant1.yourapp.com
        $host = $request->getHost();
        $parts = explode('.', $host);
        $subdomain = $parts[0] ?? null;

        if ($subdomain && ! in_array($subdomain, ['www', 'app', 'admin'])) {
            return Tenant::where('slug', $subdomain)->first();
        }

        // Example 2: from route parameter  → /tenant/{tenant}
        if ($request->route()?->parameter('tenant')) {
            return Tenant::where('id', $request->route('tenant'))->first();
        }

        // Example 3: from session  → for dashboard tenant switching
        if (session()->has('tenant_id')) {
            return Tenant::find(session('tenant_id'));
        }

        return null;
    }
}
