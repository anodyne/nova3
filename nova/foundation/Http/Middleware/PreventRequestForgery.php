<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

class PreventRequestForgery extends Middleware
{
    /**
     * The URIs that should be excluded from request forgery verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
