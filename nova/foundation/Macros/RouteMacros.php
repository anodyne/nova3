<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Illuminate\Routing\Route;
use Nova\Pages\Models\Page;

class RouteMacros
{
    public function findPageFromRoute(): Closure
    {
        return function () {
            /** @var Route $route */
            $route = $this;

            return Page::key($route->getName())->first();
        };
    }
}
