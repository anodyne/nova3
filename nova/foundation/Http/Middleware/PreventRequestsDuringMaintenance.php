<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Illuminate\Foundation\Http\MaintenanceModeBypassCookie;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    protected function bypassResponse(string $secret)
    {
        return redirect()->route('admin.system-overview')->withCookie(
            MaintenanceModeBypassCookie::create($secret)
        );
    }
}
